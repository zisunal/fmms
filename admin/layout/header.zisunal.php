<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - FMMS</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Protest+Guerrilla&family=Protest+Strike&display=swap" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/app_light.css') }}">
</head>
<body>
    <div class="zs-wrapper">
        <header>
            <div class="zs-header__logo">
                <a href="./">
                    <img src="{{ asset('assets/img/icon.png') }}" alt="FMMS Logo">
                </a>
            </div>
            <form id="srch" class="zs-header__form">
                <input type="text" placeholder="Search your FMMS Admin" required>
                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </header>
        <main>
            <div class="zs-main__sidebar">
                <ul>
                    <li>
                        <a href="./">
                            <i class="fa-solid fa-house"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="themes" class="active">
                            <i class="fa-brands fa-affiliatetheme"></i>
                            <span>Themes</span>
                        </a>
                    </li>
                    <li>
                        <a href="./">
                            <i class="fa-brands fa-buromobelexperte"></i>
                            <span>Plugins</span>
                        </a>
                    </li>
                    <li>
                        <a href="./">
                            <i class="fa-solid fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="./">
                            <i class="fa-regular fa-comments"></i>
                            <span>Contacts</span>
                        </a>
                    </li>
                    <li>
                        <a href="./">
                            <i class="fa-regular fa-flag"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="./">
                            <i class="fa-solid fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="zs-main__content">