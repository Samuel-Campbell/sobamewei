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

    def check_model_consistency(self, old_model, new_model, table):
        """
        Evaluates a single model from mysql with a single model from mongodb.

        If models aren't equal then update the one from mongodb. Same thing applies
        if the model is absent from mongodb

        :param old_model: models.models
        :param new_model: models.models
        :param table: MySQLTableEnum (1 - 6)
        :return: None
        """
        if not(old_model == new_model):
            ConsistencyChecker.__update(old_model, table)
            f = open(self.log_directory + 'log.txt', 'a')
            f.write("Inconsistent model found\n")
            f.close()

    def check_database_consistency(self, old_db, new_db, log=False):
        """
        Compares mysql database with the mongodb. Any difference or
        inconsistency is taken care of.

        The set difference of the old_db and the new_db are the values to be updated
        in the new db.

        The set difference between the new_db and the old_db are the values to be deleted
        from the new db

        :param old_db: {
                MySQLTableEnum: [
                    models.models,
                    models.models,
                    ...
                ]
            }
        :param new_db: {
                MySQLTableEnum: [
                    models.models,
                    models.models,
                    ...
                ]
            }
        :param log: boolean
        :return: integer (percentage of consistency)
        """
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
