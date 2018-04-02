from database.models.models import ElectronicSpecification
from mongodb import MongoDbConnector


class ElectronicSpecificationTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['ElectronicSpecification'].insert_one(model.jsonify())
        return self.select_one(model)

    def select(self):
        model_list = []
        cursor = self.client[self.database]['ElectronicSpecification'].find()
        for row in cursor:
            model = ElectronicSpecification()
            model.objectify(row)
            model_list.append(model)
        model_list.sort(key=lambda x: x.id)
        return model_list

    def select_one(self, model):
        key = {'id': model.id}
        row = self.client[self.database]['ElectronicSpecification'].find_one(key)
        model = ElectronicSpecification()
        model.objectify(row)
        return model

    def update(self, model):
        key = {'id': model.id}
        self.client[self.database]['ElectronicSpecification'].update_one(key, {'$set': model.jsonify()}, upsert=True)

    def delete(self, model):
        key = {'id': model.id}
        self.client[self.database]['ElectronicSpecification'].delete_one(key)