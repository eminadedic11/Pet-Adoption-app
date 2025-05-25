function updateNavbar() {
    const role = localStorage.getItem('role');

    ['nav-home', 'nav-adopt', 'nav-adopted', 'nav-reviews', 'nav-login', 'nav-profile', 'nav-admin', 'nav-contact']
        .forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.display = 'block';
        });

    if (!role) {
        ['nav-profile', 'nav-admin'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        });

        const loginEl = document.getElementById('nav-login');
        if (loginEl) loginEl.style.display = 'block';

    } else {
        const loginEl = document.getElementById('nav-login');
        if (loginEl) loginEl.style.display = 'none';

        const profileEl = document.getElementById('nav-profile');
        if (profileEl) profileEl.style.display = 'block';

        if (role === 'user') {
            const adminEl = document.getElementById('nav-admin');
            if (adminEl) adminEl.style.display = 'none';

        } else if (role === 'admin') {
            const adminEl = document.getElementById('nav-admin');
            if (adminEl) adminEl.style.display = 'block';

            const adminLink = document.querySelector('#nav-admin a.nav-link');
            if (adminLink) adminLink.textContent = 'Dashboard';

            ['nav-adopt', 'nav-contact'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
        }
    }
}




document.getElementById('loginForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const res = await fetch('http://localhost:80/pet-adoption-app/backend/auth/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });

        const data = await res.json();

        if (res.ok) {
            localStorage.setItem('token', data.data.token);
            localStorage.setItem('role', data.data.role);
            localStorage.setItem('userId', data.data.user_id);
            updateNavbar();
            alert('Logged in successfully!');
            window.location.href = '#homePage';


        } else {
            alert(data.message || 'Login failed!');
        }
    } catch (err) {
        console.error(err);
        alert('An error occurred during login.');
    }
});

$(document).on('submit', '#signupForm', async function (e) {
    e.preventDefault();

    const name = $('#name').val();
    const email = $('#signupEmail').val();
    const password = $('#signupPassword').val();
    const phone = $('#signupPhone').val();

    try {
        const res = await fetch('http://localhost:80/pet-adoption-app/backend/auth/register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, email, password, phone })
        });

        const data = await res.json();

        if (res.ok) {
            alert('Registration successful! You can now log in.');
            window.location.href = '#loginPage';
        } else {
            alert(data.message || 'Registration failed!');
        }
    } catch (err) {
        console.error(err);
        alert('An error occurred during registration.');
    }
});


document.addEventListener('DOMContentLoaded', () => {
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            localStorage.removeItem('token');
            localStorage.removeItem('role');
            localStorage.removeItem('userId');

            if (typeof updateNavbar === 'function') {
                updateNavbar();
            }
            window.location.href = '#homePage';
        });
    }
});

