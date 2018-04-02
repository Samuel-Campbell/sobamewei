from pymongo import MongoClient


class MongoDbConnector:
    database = 'conushop'
    user = 'root'
    password = 'isY2metT'
    host = 'localhost'

    def __init__(self):
        self.client = MongoClient(host=self.host, username=self.user, password=self.password)

    def reset(self):
        collections = self.client[self.database].collection_names()
        for name in collections:
            print('Deleting Collection: {}'.format(name))
            self.client[self.database].drop_collection(name)
        print('MongoDb reset successfully')
