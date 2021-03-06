from database.models.models import ElectronicType
from mongodb import MongoDbConnector


class ElectronicTypeTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['ElectronicType'].insert_one(model.jsonify())
        return self.select_one(model)

    def select(self):
        model_list = []
        cursor = self.client[self.database]['ElectronicType'].find()
        for row in cursor:
            model = ElectronicType()
            model.objectify(row)
            model_list.append(model)
        model_list.sort(key=lambda x: x.id)
        return model_list

    def select_one(self, model):
        key = {'id': model.id}
        row = self.client[self.database]['ElectronicType'].find_one(key)
        model = ElectronicType()
        try:
            model.objectify(row)
        except TypeError:
            pass
        return model

    def update(self, model):
        key = {'id': model.id}
        self.client[self.database]['ElectronicType'].update_one(key, {'$set': model.jsonify()}, upsert=True)

    def delete(self, model):
        key = {'id': model.id}
        self.client[self.database]['ElectronicType'].delete_one(key)
