import sys
from database.mysql.mysql import MySQLConnector
import incrementalMode


class QueryTypeEnum:
    READ = 0
    WRITE = 1

    def __init__(self):
        pass


def query_type(query):
    if 'SELECT' in query:
        return QueryTypeEnum.READ
    else:
        return QueryTypeEnum.WRITE


def shadow_read(query):
    if 'User' in query:
        pass
    elif 'LoginLog' in query:
        pass
    elif 'Transaction' in query:
        pass
    elif 'ElectronicType' in query:
        pass
    elif 'ElectronicItem' in query:
        pass
    else:
        pass


def shadow_write():
    incrementalMode.run()


if __name__ == '__main__':
    q_type = query_type(sys.argv[1])
    if q_type == QueryTypeEnum.READ:
        shadow_read(sys.argv[1])
    else:
        shadow_write()
    MySQLConnector().update_last_forklift()
