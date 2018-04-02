import unittest

import models


class TestModels(unittest.TestCase):
    def test_electronic_item_equals(self):
        # success
        obj1 = models.ElectronicItem()
        obj2 = models.ElectronicItem()
        self.assertTrue(obj1 == obj2)

        # Failure
        obj2.expiryForUser = 6
        self.assertFalse(obj1 == obj2)

    def test_electronic_specification_equals(self):
        # success
        obj1 = models.ElectronicSpecification()
        obj2 = models.ElectronicSpecification()
        self.assertTrue(obj1 == obj2)

        # failure
        obj2.displaySize = "big"
        self.assertFalse(obj1 == obj2)

    def test_electronic_type_equals(self):
        # success
        obj1 = models.ElectronicType()
        obj2 = models.ElectronicType()
        self.assertTrue(obj1 == obj2)

        # failure
        obj2.dimensionUnit = 500
        self.assertFalse(obj1 == obj2)

    def test_login_log_equals(self):
        # success
        obj1 = models.LoginLog()
        obj2 = models.LoginLog()
        self.assertTrue(obj1 == obj2)

        obj2.timestamp = 4000
        self.assertFalse(obj1 == obj2)

    def transaction_equals(self):
        # success
        obj1 = models.Transaction()
        obj2 = models.Transaction()
        self.assertTrue(obj1 == obj2)

        # failure
        obj2.id = 532
        self.assertFalse(obj1 == obj2)

    def test_user_equals(self):
        obj1 = models.User()
        obj2 = models.User()
        self.assertTrue(obj1 == obj2)

        obj2.id = 4342
        self.assertFalse(obj1 == obj2)