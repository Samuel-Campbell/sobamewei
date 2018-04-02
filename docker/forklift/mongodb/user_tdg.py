from mongodb import MongoDbConnector


class UserTdg(MongoDbConnector):
    def __init__(self):
        MongoDbConnector.__init__(self)

    def insert(self, model):
        self.client[self.database]['User'].insert_one(model.jsonify())