import time
from database.mongodb import electornic_type_tdg, electronic_item_tdg, electronic_specification_tdg, \
    login_log_tdg, transaction_tdg, user_tdg
from database.mysql.mysql import MySQLConnector, MySQLTableEnum
from consistency_checker.consistency_checker import ConsistencyChecker


def mysql_dictionary():
    electronic_item_list = mysql_connector.select_electronic_item()
    electronic_specification_list = mysql_connector.select_electronic_specification()
    electronic_type_list = mysql_connector.select_electronic_type()
    login_log_list = mysql_connector.select_login_log()
    transaction_list = mysql_connector.select_transaction()
    user_list = mysql_connector.select_user()

    mysql_dict = {
        MySQLTableEnum.User: user_list,
        MySQLTableEnum.Transaction: transaction_list,
        MySQLTableEnum.LoginLog: login_log_list,
        MySQLTableEnum.ElectronicType: electronic_type_list,
        MySQLTableEnum.ElectronicSpecification: electronic_specification_list,
        MySQLTableEnum.ElectronicItem: electronic_item_list
    }

    return mysql_dict


def mongodb_dictionary():
    electronic_item_list = electronic_item_tdg.ElectronicItemTdg().select()
    electronic_specification_list = electronic_specification_tdg.ElectronicSpecificationTdg().select()
    electronic_type_list = electornic_type_tdg.ElectronicTypeTdg().select()
    login_log_list = login_log_tdg.LoginLogTdg().select()
    transaction_list = transaction_tdg.TransactionTdg().select()
    user_list = user_tdg.UserTdg().select()

    mongodb_dict = {
        MySQLTableEnum.User: user_list,
        MySQLTableEnum.Transaction: transaction_list,
        MySQLTableEnum.LoginLog: login_log_list,
        MySQLTableEnum.ElectronicType: electronic_type_list,
        MySQLTableEnum.ElectronicSpecification: electronic_specification_list,
        MySQLTableEnum.ElectronicItem: electronic_item_list
    }

    return mongodb_dict


def insert_into_mongodb(mysql_dict):
    for model in mysql_dict[MySQLTableEnum.ElectronicItem]:
        electronic_item_tdg.ElectronicItemTdg().insert(model)

    for model in mysql_dict[MySQLTableEnum.ElectronicSpecification]:
        electronic_specification_tdg.ElectronicSpecificationTdg().insert(model)

    for model in mysql_dict[MySQLTableEnum.ElectronicType]:
        electornic_type_tdg.ElectronicTypeTdg().insert(model)

    for model in mysql_dict[MySQLTableEnum.LoginLog]:
        login_log_tdg.LoginLogTdg().insert(model)

    for model in mysql_dict[MySQLTableEnum.Transaction]:
        transaction_tdg.TransactionTdg().insert(model)

    for model in mysql_dict[MySQLTableEnum.User]:
        user_tdg.UserTdg().insert(model)


def run():
    # select all form mysql
    mysql_dict = mysql_dictionary()

    # insert new data
    insert_into_mongodb(mysql_dict)

    # collect inserted data for consistency check
    mongodb_dict = mongodb_dictionary()

    # consistency check
    ConsistencyChecker().check_database_consistency(mysql_dict, mongodb_dict, log=True)


if __name__ == '__main__':
    mysql_connector = MySQLConnector()
    while True:
        run()

        # perform update in mysql
        mysql_connector.update_last_forklift()

        time.sleep(300)