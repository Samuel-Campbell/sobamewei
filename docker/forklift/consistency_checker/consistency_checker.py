import os
from database.mysql.mysql import MySQLTableEnum
from database.mongodb import electornic_type_tdg, electronic_item_tdg, electronic_specification_tdg, \
    login_log_tdg, transaction_tdg, user_tdg


class ConsistencyChecker:
    __root_directory = os.path.abspath(__file__ + "r/../../")
    __rel_path = r'logs/'
    log_directory = os.path.join(__root_directory, __rel_path)

    def __init__(self):
        pass

    def check_consistency(self, old_db, new_db, log=False):
        inconsistent_count = 0
        data_length = 0

        for key in old_db:
            data_length += len(old_db[key])
            old_set = set(old_db[key])
            new_set = set(new_db[key])
            update_set = old_set.difference(new_set)

            for model in update_set:
                ConsistencyChecker.__update(model, key)

            delete_set = new_set.difference(old_set)
            for model in delete_set:
                ConsistencyChecker.__delete(model, key)

            inconsistent_count += len(update_set) + len(delete_set)
        inconsistent_ratio = (data_length - inconsistent_count) / data_length * 100
        if log:
            f = open(self.log_directory + 'log.txt', 'a')
            f.write("Consistent ratio: {}\n".format(inconsistent_ratio))
            f.close()
        return inconsistent_ratio

    @staticmethod
    def __delete(model, table):
        if table == MySQLTableEnum.User:
            user_tdg.UserTdg().delete(model)
        elif table == MySQLTableEnum.ElectronicSpecification:
            electronic_specification_tdg.ElectronicSpecificationTdg().delete(model)
        elif table == MySQLTableEnum.ElectronicType:
            electornic_type_tdg.ElectronicTypeTdg().delete(model)
        elif table == MySQLTableEnum.ElectronicItem:
            electronic_item_tdg.ElectronicItemTdg().delete(model)
        elif table == MySQLTableEnum.LoginLog:
            login_log_tdg.LoginLogTdg().delete(model)
        elif table == MySQLTableEnum.Transaction:
            transaction_tdg.TransactionTdg().delete(model)

    @staticmethod
    def __update(model, table):
        if table == MySQLTableEnum.User:
            user_tdg.UserTdg().update(model)
        elif table == MySQLTableEnum.ElectronicSpecification:
            electronic_specification_tdg.ElectronicSpecificationTdg().update(model)
        elif table == MySQLTableEnum.ElectronicType:
            electornic_type_tdg.ElectronicTypeTdg().update(model)
        elif table == MySQLTableEnum.ElectronicItem:
            electronic_item_tdg.ElectronicItemTdg().update(model)
        elif table == MySQLTableEnum.LoginLog:
            login_log_tdg.LoginLogTdg().update(model)
        elif table == MySQLTableEnum.Transaction:
            transaction_tdg.TransactionTdg().update(model)
