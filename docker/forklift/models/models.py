class ElectronicItem:
    def __init__(self):
        self.id = None
        self.ElectronicSpecification_id = ElectronicSpecification()
        self.serialNumber = None
        self.user_id = User()
        self.expiryForUser = None

    def jsonify(self):
        return {
            'id': self.id,
            'ElectronicSpecification_id': self.ElectronicSpecification_id.jsonify(),
            'serialNumber': self.serialNumber,
            'user_id': self.user_id.jsonify(),
            'expiryForUser': self.expiryForUser
        }

    def __eq__(self, other):
        return \
            self.id == other.id and \
            self.ElectronicSpecification_id == other.ElectronicSpecification_id and \
            self.serialNumber == other.serialNumber and \
            self.user_id == other.user_id and \
            self.expiryForUser == other.expiryForUser


class ElectronicSpecification:
    def __init__(self):
        self.id = None
        self.dimension = None
        self.weight = None
        self.modelNumber = None
        self.brandName = None
        self.hdSize = None
        self.price = None
        self.processorType = None
        self.ramSize = None
        self.cpuCores = None
        self.batteryInfo = None
        self.os = None
        self.camera = None
        self.touchScreen = None
        self.ElectronicType_id = ElectronicType()
        self.displaySize = None
        self.image = None

    def jsonify(self):
        return {
            'id': self.id,
            'dimension': self.dimension,
            'weight': self.weight,
            'modelNumber': self.modelNumber,
            'brandName': self.brandName,
            'hdSize': self.hdSize,
            'price': self.price,
            'processorType': self.processorType,
            'ramSize': self.ramSize,
            'cpuCores': self.cpuCores,
            'batteryInfo': self.batteryInfo,
            'os': self.os,
            'camera': self.camera,
            'touchScreen': self.touchScreen,
            'ElectronicType_id': self.ElectronicType_id.jsonify(),
            'displaySize': self.displaySize,
            'image': self.image
        }

    def __eq__(self, other):
        return \
            self.id == other.id and \
            self.dimension == other.dimension and \
            self.weight == other.weight and \
            self.modelNumber == other.modelNumber and \
            self.brandName == other.brandName and \
            self.hdSize == other.hdSize and \
            self.price == other.price and \
            self.processorType == other.processorType and \
            self.ramSize == other.ramSize and \
            self.cpuCores == other.cpuCores and \
            self.batteryInfo == other.batteryInfo and \
            self.os == other.os and \
            self.camera == other.camera and \
            self.touchScreen == other.touchScreen and \
            self.ElectronicType_id == other.ElectronicType_id and \
            self.displaySize == other.displaySize and \
            self.image == other.image

class ElectronicType:
    def __init__(self):
        self.id = None
        self.name = None
        self.dimensionUnit = None
        self.screenSizeUnit = None

    def jsonify(self):
        return {
            'id': self.id,
            'name': self.name,
            'dimensionUnit': self.dimensionUnit,
            'screenSizeUnit': self.screenSizeUnit
        }

    def __eq__(self, other):
        return \
            self.id == other.id and \
            self.name == other.name and \
            self.dimensionUnit == other.dimensionUnit and \
            self.screenSizeUnit == other.screenSizeUnit

class LoginLog:
    def __init__(self):
        self.id = None
        self.timestamp = None
        self.User_id = User()

    def jsonify(self):
        return {
            'id': self.id,
            'timestamp': self.timestamp,
            'User_id': self.User_id.jsonify()
        }

    def __eq__(self, other):
        return \
            self.id == other.id and \
            self.timestamp == other.timestamp and \
            self.User_id == other.User_id


class Transaction:
    def __init__(self):
        self.id = None
        self.ElectronicSpec_id = ElectronicSpecification()
        self.item_id = None
        self.serialNumber = None
        self.timestamp = None
        self.customer_id = User()

    def jsonify(self):
        return {
            'id': self.id,
            'ElectronicSpec_id': self.ElectronicSpec_id.jsonify(),
            'item_id': self.item_id,
            'serialNumber': self.serialNumber,
            'timestamp': self.timestamp,
            'customer_id': self.customer_id.jsonify()
        }

    def __eq__(self, other):
        return \
            self.id == other.id and \
            self.ElectronicSpec_id == other.ElectronicSpec_id and \
            self.item_id == other.item_id and \
            self.serialNumber == other.serialNumber and \
            self.timestamp == other.timestamp and \
            self.customer_id == other.customer_id


class User:
    def __init__(self):
        self.id = None
        self.firstName = None
        self.lastName = None
        self.email = None
        self.phone = None
        self.admin = None
        self.physicalAddress = None
        self.password = None
        self.remember_token = None

    def jsonify(self):
        return {
            'id': self.id,
            'firstName': self.firstName,
            'lastName': self.lastName,
            'email': self.email,
            'phone': self.phone,
            'admin': self.admin,
            'physicalAddress': self.physicalAddress,
            'password': self.password,
            'remember_token': self.remember_token
        }

    def __eq__(self, other):
        return \
            self.id == other.id and \
            self.firstName == other.firstName and \
            self.lastName == other.lastName and \
            self.email == other.email and \
            self.phone == other.phone and \
            self.admin == other.admin and \
            self.physicalAddress == other.physicalAddress and \
            self.password == other.password and \
            self.remember_token == other.remember_token