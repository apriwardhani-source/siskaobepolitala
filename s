[1mdiff --git a/laravel b/laravel[m
[1mindex 3e39afd..a0abdd2 100644[m
Binary files a/laravel and b/laravel differ
[1mdiff --git a/resources/views/admin/manage_users.blade.php b/resources/views/admin/manage_users.blade.php[m
[1mindex f605b6a..40c66d0 100644[m
[1m--- a/resources/views/admin/manage_users.blade.php[m
[1m+++ b/resources/views/admin/manage_users.blade.php[m
[36m@@ -30,27 +30,27 @@[m
                     <thead>[m
                         <tr>[m
                             <th scope="col"[m
[31m-                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama[m
[32m+[m[32m                                class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama[m
                             </th>[m
                             <th scope="col"[m
[31m-                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Email[m
[32m+[m[32m                                class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Email[m
                             </th>[m
                             <th scope="col"[m
[31m-                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Role[m
[32m+[m[32m                                class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Role[m
                             </th>[m
                             <th scope="col"[m
[31m-                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi[m
[32m+[m[32m                                class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi[m
                             </th>[m
                         </tr>[m
                     </thead>[m
                     <tbody class="divide-y divide-gray-200">[m
                         @forelse($users as $user)[m
                             <tr>[m
[31m-                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $user->name }}</td>[m
[31m-                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $user->email }}</td>[m
[31m-                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white capitalize">{{ $user->role }}[m
[32m+[m[32m                                <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ $user->name }}</td>[m
[32m+[m[32m                                <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ $user->email }}</td>[m
[32m+[m[32m                                <td class="px-4 py-4 whitespace-nowrap text-sm text-white capitalize">{{ $user->role }}[m
                                 </td>[m
[31m-                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">[m
[32m+[m[32m                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">[m
                                     <!-- Bungkus tombol dalam div untuk kelas action-buttons (opsional, bisa juga langsung ke button/link) -->[m
                                     <div class="action-buttons flex space-x-2">[m
                                         <!-- Tambahkan flex dan space-x untuk jarak -->[m
[36m@@ -75,7 +75,7 @@[m [mclass="inline">[m
                             </tr>[m
                         @empty[m
                             <tr>[m
[31m-                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center">[m
[32m+[m[32m                                <td colspan="4" class="px-4 py-4 whitespace-nowrap text-sm text-gray-300 text-center">[m
                                     Tidak ada data user.</td>[m
                             </tr>[m
                         @endforelse[m
