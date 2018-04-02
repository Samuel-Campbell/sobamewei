import unittest
from consistency_checker import ConsistencyChecker


class TestConsistencyChecker(unittest.TestCase):
    def test_check_consistency(self):
        class MockObj:
            def __init__(self, prop):
                self.prop = prop

            def __eq__(self, other):
                return self.prop == other.prop

            def __hash__(self):
                return self.prop

        mock_old_db = {
            'table1': [MockObj(1), MockObj(2), MockObj(3)],
            'table2': [MockObj(4), MockObj(5), MockObj(6)],
        }

        mock_new_db = {
            'table1': [MockObj(1), MockObj(2), MockObj(3)],
            'table2': [MockObj(4), MockObj(5), MockObj(6)],
        }

        cc = ConsistencyChecker()
        result = cc.check_consistency(mock_old_db, mock_new_db)
        self.assertTrue(result == 100)
