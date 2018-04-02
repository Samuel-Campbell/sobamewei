from database.models.models import ElectronicItem
from mongodb import MongoDbConnector


class ElectronicItemTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['ElectronicItem'].insert_one(model.jsonify())

    def select(self):
        model_list = []
        cursor = self.client[self.database]['ElectronicItem'].find()
        for row in cursor:
            model = ElectronicItem()
            model.objectify(row)
            model_list.append(model)
        model_list.sort(key=lambda x: x.id)
        return model_list

    def update(self, model):
        key = {'id': model.id}
        self.client[self.database]['ElectronicItem'].update_one(key, {'$set': model.jsonify()}, upsert=True)

    def delete(self, model):
        key = {'id': model.id}
        self.client[self.database]['ElectronicItem'].delete_one(key)
