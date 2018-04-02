from database.models.models import LoginLog
from mongodb import MongoDbConnector


class LoginLogTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['LoginLog'].insert_one(model.jsonify())

    def select(self):
        model_list = []
        cursor = self.client[self.database]['LoginLog'].find()
        for row in cursor:
            model = LoginLog()
            model.objectify(row)
            model_list.append(model)
        model_list.sort(key=lambda x: x.id)
        return model_list

    def update(self, model):
        key = {'id': model.id}
        self.client[self.database]['LoginLog'].update_one(key, {'$set': model.jsonify()}, upsert=True)

    def delete(self, model):
        key = {'id': model.id}
        self.client[self.database]['LoginLog'].delete_one(key)