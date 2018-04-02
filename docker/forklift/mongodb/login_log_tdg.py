from mongodb import MongoDbConnector


class LoginLogTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['LoginLog'].insert_one(model.jsonify())