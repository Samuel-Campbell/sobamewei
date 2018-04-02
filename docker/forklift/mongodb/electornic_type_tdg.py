from mongodb import MongoDbConnector


class ElectronicTypeTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['ElectronicType'].insert_one(model.jsonify())

    def select(self):
        cursor = self.client[self.database]['ElectronicType'].find()
        for row in cursor:
            print(row)
