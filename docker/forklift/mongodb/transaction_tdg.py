from mongodb import MongoDbConnector
from models.models import Transaction


class TransactionTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['Transaction'].insert_one(model.jsonify())

    def select(self):
        model_list = []
        cursor = self.client[self.database]['Transaction'].find()
        for row in cursor:
            model = Transaction()
            model.objectify(row)
            model_list.append(model)
        model_list.sort(key=lambda x: x.id)
        return model_list