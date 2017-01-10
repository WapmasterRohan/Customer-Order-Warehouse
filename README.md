# Customer-Order-Warehouse

A warehouse chain keeps several items to supply to its customers on the basis of order released by them for particular item(s). The warehouse has number of stores and the stores hold a variety of items. The warehouse is required to meet all of a customer’s order requirements from those stores located in the customer’s city. The warehouse chain wants an efficient database design for its business to meet the increased service demand of its customers.

Requirement Definition and Analysis:

The following requirements have been identifies after the detailed analysis of the existing system:

The quantity of items held (QTY-HELD) by each store appears in relation HOLD and the stores themselves are described in relation STORES.

The database stores information about the enterprise customers.

The city location of the customer, together with the data of the customer’s first order, is stored in the database.

Each customer lives in one city only.

The customers order items from the enterprise. Each such order can be for any quantity (QTY-ORDERED) of any number of items. The items ordered are stored in ITEM-ORDERED.

Each order is uniquely identified by its order number (ORDER-NO).

The location of store is also kept in the database. Each store is located in one city and there may be many stores in that city.

Each city has a main coordination centre known as HDQ-ADD for all it stores and there is one HDQ-ADD for each city.

The database contains some derived data. The data in ITEM-CITY are derived from relations STORES and HOLD. Thus each item is taken and the quantities of the item (QTY-HELD) in all the stores in a city are totalled into QTY-IN-CITY and stored in ITEM-CITY.
