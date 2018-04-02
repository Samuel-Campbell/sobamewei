import sys
from database.mysql.mysql import MySQLConnector, MySQLTableEnum
import incrementalMode
from database.mongodb import electornic_type_tdg, electronic_item_tdg, electronic_specification_tdg, \
    login_log_tdg, transaction_tdg, user_tdg
from consistency_checker.consistency_checker import ConsistencyChecker


class QueryTypeEnum:
    READ = 0
    WRITE = 1

    def __init__(self):
        pass


def query_type(query):
    if 'SELECT' in query:
        return QueryTypeEnum.READ
    else:
        return QueryTypeEnum.WRITE


def shadow_write():
    incrementalMode.run()


def shadow_read():
    mysql_connector = MySQLConnector()
    electronic_item_list = mysql_connector.select_electronic_item()
    electronic_specification_list = mysql_connector.select_electronic_specification()
    electronic_type_list = mysql_connector.select_electronic_type()
    login_log_list = mysql_connector.select_login_log()
    transaction_list = mysql_connector.select_transaction()
    user_list = mysql_connector.select_user()

    for model in electronic_type_list:
        new_model = electornic_type_tdg.ElectronicTypeTdg().select_one(model)
        ConsistencyChecker().check_model_consistency(model, new_model, MySQLTableEnum.ElectronicType)

    for model in electronic_item_list:
        new_model = electronic_item_tdg.ElectronicItemTdg().select_one(model)
        ConsistencyChecker().check_model_consistency(model, new_model, MySQLTableEnum.ElectronicItem)

    for model in electronic_specification_list:
        new_model = electronic_specification_tdg.ElectronicSpecificationTdg().select_one(model)
        ConsistencyChecker().check_model_consistency(model, new_model, MySQLTableEnum.ElectronicSpecification)

    for model in login_log_list:
        new_model = login_log_tdg.LoginLogTdg().select_one(model)
        ConsistencyChecker().check_model_consistency(model, new_model, MySQLTableEnum.LoginLog)

    for model in transaction_list:
        new_model = transaction_tdg.TransactionTdg().select_one(model)
        ConsistencyChecker().check_model_consistency(model, new_model, MySQLTableEnum.Transaction)

    for model in user_list:
        new_model = user_tdg.UserTdg().select_one(model)
        ConsistencyChecker().check_model_consistency(model, new_model, MySQLTableEnum.User)


if __name__ == '__main__':
    q_type = query_type(sys.argv[1])
    if q_type == QueryTypeEnum.READ:
        shadow_read()
    else:
        shadow_write()
    MySQLConnector().update_last_forklift()
