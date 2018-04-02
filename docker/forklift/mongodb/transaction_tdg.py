from mongodb import MongoDbConnector


class TransactionTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['Transaction'].insert_one(model.jsonify())