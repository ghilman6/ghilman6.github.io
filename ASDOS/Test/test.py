# arr = [1,23,4,2,6]
# arr.sort()
# print(arr[-2])

# def count_by_len(arr, n):
#     a= 0
#     for i in range(len(arr)):
#         if len(arr[i])>=n:
#             a+=1
#     return a

# arr = ["satu", "dua", "tiga", "empat", "lima"]
# print(count_by_len(arr,4))

# def faktorial(n):
#     if n == 1:
#         return 1
#     else:    
#         return faktorial(n-1)*n

# print(faktorial(5))

def sum_kelipatan(arr, n):
    a= 0
    for i in range(len(arr)):
        if arr[i]%n==0:
            a+=arr[i]
    return a
arr = [2, 9, -4, 60, 33, 17]
arr = [2, 9, -4, 60, 33, 17]
print(sum_kelipatan(arr,7))
