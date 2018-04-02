from mongodb import MongoDbConnector


class ElectronicSpecificationTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['ElectronicSpecification'].insert_one(model.jsonify())