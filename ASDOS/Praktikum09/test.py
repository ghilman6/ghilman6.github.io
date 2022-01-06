# name = "Hello WorldSaya"
# name = name.split(" ")
# cek = 0
# for i in name:
#     if i[0].isupper():
#         cek +=1    
# if cek == len(name):
#     print(True)
# else:
#     print(False)

# f = open("nama.txt")
# h = []
# u = []
# g = []
# for each_line in f:
#     h.append(each_line.strip())
# f.close()

# print(h)

# for i in range(len(h)):
#     u.append(h[i].split())

# for i in u:
#     g.append(i[1])
# print(g)

# umur = {'anna':349, 'elsa':22341, 'bella':12344}


# print(umur.values())

# 

# def bubble_sort(arr):
#     for i in range(len(arr)-1):
#         for j in range(len(arr)-1-i):
#             if arr[j] > arr[j+1]:
#                 arr[j], arr[j+1] = arr[j+1], arr[j]

# def insertion_sort(arr):
#     for i in range(1, len(arr)):

#         key = arr[i]
#         j = i - 1
#         while j >= 0 and arr[j] > key:
#             arr[j+1] = arr[j]
#             j = j - 1
#             arr[j+1] = key

# def merge_sort(arr,i = 0):
    
#     if len(arr) > 1:
#         mid = len(arr) // 2
#         leftarr = arr[:mid]
#         rightarr = arr[mid:]
#         merge_sort(leftarr)
#         merge_sort(rightarr)
#         print(leftarr)
#         print(rightarr)
#         # i +=1
#         merge(leftarr, rightarr, arr)

# def merge(left, right, arr):
#     i, j, k = 0, 0, 0
#     while i < len(left) and j < len(right):
#         if left[i] < right[j]:
#             arr[k] = left[i]
#             i = i + 1
#         else:
#             arr[k] = right[j]
#             j = j + 1
#             k = k + 1
#     while i < len(left):
#         arr[k] = left[i]
#         k = k + 1
#         i = i + 1
#     while j < len(right):
#         arr[k] = right[j]
#         k = k + 1
#         j = j + 1


# arr = [1,23,41,12]
# merge_sort(arr)
# print(arr)

nama = "Ghilman Firdaus"
for element in nama:
    print(element)