from mongodb import MongoDbConnector


class ElectronicItemTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['ElectronicItem'].insert_one(model.jsonify())