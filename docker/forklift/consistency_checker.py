import os


class ConsistencyChecker:
    __root_directory = os.path.abspath(__file__ + "r/../")
    __rel_path = r'logs/'
    log_directory = os.path.join(__root_directory, __rel_path)

    def __init__(self):
        pass

    def check_consistency(self, old_db, new_db):
        inconsistent_count = 0
        data_length = 0

        for key in old_db:
            data_length += len(old_db[key])

            for i in range(len(old_db[key])):
                if not(old_db[key][i] == new_db[key][i]):
                    inconsistent_count += 1
                    # update mongodb

        inconsistent_ratio = (data_length - inconsistent_count) / data_length
        file = open(self.log_directory, 'a')
        file.write("Inconsistent ratio: {}".format(inconsistent_ratio))
        file.close()