from database.models.models import User
from mongodb import MongoDbConnector


class UserTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['User'].insert_one(model.jsonify())
        return self.select_one(model)

    def select(self):
        model_list = []
        cursor = self.client[self.database]['User'].find()
        for row in cursor:
            model = User()
            model.objectify(row)
            model_list.append(model)
        model_list.sort(key=lambda x: x.id)
        return model_list

    def select_one(self, model):
        key = {'id': model.id}
        row = self.client[self.database]['User'].find_one(key)
        model = User()
        try:
            model.objectify(row)
        except TypeError:
            pass
        return model

    def update(self, model):
        key = {'id': model.id}
        self.client[self.database]['User'].update_one(key, {'$set': model.jsonify()}, upsert=True)

    def delete(self, model):
        key = {'id': model.id}
        self.client[self.database]['User'].delete_one(key)