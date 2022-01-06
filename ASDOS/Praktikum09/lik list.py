class Node:
    def __init__(self, data = None):
        self.data = data
        self.next = None    

class LinkedList:
    def __init__(self):
        self.head = None
    def add_first(self, new_data):
        pass
    def add_last(self, new_data):
        pass
    def print(self):
        pass

class Stack:
    def __init__(self):
        self.top = None
        self.size = 0

    def push(self, data):
        node = Node(data)
        node.next = self.top
        self.top = node
        self.size +=1

    def getSize(self):
        return self.size

    def pop(self):
        self.top = self.top.next
        self.size -=1


# node1 = Node(8)
# node2 = Node(3)
# node3 = Node(6)
# node4 = Node(15)
# node5 = Node(4)

# node1.next = node2
# node2.next = node3
# node3.next = node5
# node5.next = node4

# mylinkedlist = LinkedList()
# mylinkedlist.head = node1

# current_node = mylinkedlist.head
# while current_node is not None:
# # do something
#     print(current_node.data)
#     current_node = current_node.next

myStack = Stack()
myStack.push(8)
myStack.push(1)
myStack.push(3)
myStack.push(2)
myStack.pop()
current_node = myStack.top
while current_node is not None:
# do something
    print(current_node.data)
    current_node = current_node.next

