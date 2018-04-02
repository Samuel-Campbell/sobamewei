from database.mongodb import mongodb, electornic_type_tdg, electronic_item_tdg, electronic_specification_tdg, \
    login_log_tdg, transaction_tdg, user_tdg
from database.mysql.mysql import MySQLConnector, MySQLTableEnum


if __name__ == '__main__':
    print("Performing data migration from MySQL to MongoDB")

    mysql_connector = MySQLConnector()

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

    mongodb.MongoDbConnector().reset()

    for model in electronic_item_list:
        electronic_item_tdg.ElectronicItemTdg().insert(model)

    for model in electronic_specification_list:
        electronic_specification_tdg.ElectronicSpecificationTdg().insert(model)

    for model in electronic_type_list:
        electornic_type_tdg.ElectronicTypeTdg().insert(model)

    for model in login_log_list:
        login_log_tdg.LoginLogTdg().insert(model)

    for model in transaction_list:
        transaction_tdg.TransactionTdg().insert(model)

    for model in user_list:
        user_tdg.UserTdg().insert(model)

    mysql_connector.update_last_forklift()
    print('Migration Complete!')