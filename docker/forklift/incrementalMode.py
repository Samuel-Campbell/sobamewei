import time
from database.mongodb import electornic_type_tdg, electronic_item_tdg, electronic_specification_tdg, \
    login_log_tdg, transaction_tdg
from database.mysql.mysql import MySQLConnector

from database.mongodb import user_tdg

if __name__ == '__main__':
    mysql_connector = MySQLConnector()
    while True:
        electronic_item_list = mysql_connector.select_electronic_item(0)
        electronic_specification_list = mysql_connector.select_electronic_specification(0)
        electronic_type_list = mysql_connector.select_electronic_type(0)
        login_log_list = mysql_connector.select_login_log(0)
        transaction_list = mysql_connector.select_transaction(0)
        user_list = mysql_connector.select_user(0)

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

        time.sleep(300)