def selection_sort(arr):
    for i in range(len(arr)-1): #perlangan
        min_idx = i # ini menentukan min sementara
        for j in range(i+1, len(arr)): # looping untuk membandingkan 
            if arr[j] < arr [min_idx]: # ketika indeks arr yang dibandingkan lebih kecil dari min_idx
                min_idx = j # maka min_idx akan bertukar 
        arr[i], arr[min_idx] = arr[min_idx], arr[i] #swap 
        
def bubble_sort(arr):
    for i in range(len(arr)-1):#perulangan luar
        print("ini iterasi luar ke-",i+1,arr)
        for j in range(len(arr)-1-i):# perulangan yang membandingkan 
            print("ini iterasi dalam ke-",j+1,arr)
            if arr[j] > arr[j+1]: # indeks awal dibandingkan dengan indeks selanjutnya
                arr[j], arr[j+1] = arr[j+1], arr[j] #swap

arr = [4,3,2,6,5]
bubble_sort(arr)
print(arr)
