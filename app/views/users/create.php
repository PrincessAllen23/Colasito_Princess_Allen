<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sign Up - Glassmorphism</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            background-attachment: fixed;
        }
        .glass-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center font-sans text-white">

    <div class="p-8 rounded-3xl w-full max-w-md glass-container">
        
        <div class="flex flex-col items-center mb-6">
            <div class="bg-white/20 rounded-full p-3 border border-white/30 shadow-md">
                <i class="fa-solid fa-user-graduate text-white text-3xl drop-shadow-lg"></i>
            </div>
            <h2 class="text-3xl font-bold text-white mt-3 drop-shadow-md">Create Your Account</h2>
            <p class="text-gray-200 text-sm">Join our vibrant community!</p>
        </div>

        <form action="<?=site_url('users/create')?>" method="POST" class="space-y-5">
            
            <div>
                <label class="block text-gray-100 mb-1 font-medium">First Name</label>
                <input type="text" name="fname" placeholder="Enter your first name" required
                    class="w-full px-4 py-3 bg-white/5 text-white border border-white/20 rounded-xl focus:ring-2 focus:ring-cyan-400 focus:outline-none transition duration-200">
            </div>

            <div>
                <label class="block text-gray-100 mb-1 font-medium">Last Name</label>
                <input type="text" name="lname" placeholder="Enter your last name" required
                    class="w-full px-4 py-3 bg-white/5 text-white border border-white/20 rounded-xl focus:ring-2 focus:ring-cyan-400 focus:outline-none transition duration-200">
            </div>

            <div>
                <label class="block text-gray-100 mb-1 font-medium">Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required
                    class="w-full px-4 py-3 bg-white/5 text-white border border-white/20 rounded-xl focus:ring-2 focus:ring-cyan-400 focus:outline-none transition duration-200">
            </div>

            <button type="submit"
                    class="w-full bg-white/20 hover:bg-white/30 text-white font-semibold py-3 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 border border-white/20">
                <i class="fa-solid fa-user-plus mr-2"></i> Sign Up
            </button>
        </form>
    </div>
</body>
</html>