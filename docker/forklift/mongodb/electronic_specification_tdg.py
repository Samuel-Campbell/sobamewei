from mongodb import MongoDbConnector
from models.models import ElectronicSpecification


class ElectronicSpecificationTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['ElectronicSpecification'].insert_one(model.jsonify())

    def select(self):
        model_list = []
        cursor = self.client[self.database]['ElectronicSpecification'].find()
        for row in cursor:
            model = ElectronicSpecification()
            model.objectify(row)
            model_list.append(model)
        model_list.sort(key=lambda x: x.id)
        return model_list