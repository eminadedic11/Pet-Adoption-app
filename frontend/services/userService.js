function loadUserProfile() {
    const userId = localStorage.getItem('userId');
    if (!userId) {
        alert('User not logged in');
        return;
    }

    fetch(`http://localhost:80/pet-adoption-app/backend/users/${userId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch user data');
            }
            return response.json();
        })
        .then(user => {
            console.log('Fetched user:', user);
            const nameInput = document.querySelector('#name');
            const emailInput = document.querySelector('#email');
            const phoneInput = document.querySelector('#phone');

            if (nameInput) nameInput.value = user.name || '';
            if (emailInput) emailInput.value = user.email || '';
            if (phoneInput) phoneInput.value = user.phone || '';
        })
        .catch(err => {
            console.error('Error loading user profile:', err);
            alert('Error loading user profile');
        });
}

loadUserProfile();

function loadUserOverview() {
    const token = localStorage.getItem('token');
    if (!token) {
        console.warn('No token in localStorage.');
        return;
    }

    fetch('http://localhost:80/pet-adoption-app/backend/users', {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    })
        .then(res => res.json())
        .then(users => {
            const tbody = document.getElementById('userOverviewTableBody');
            if (!tbody) return;

            tbody.innerHTML = '';

            if (users.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-muted text-center">No users found.</td></tr>';
                return;
            }

            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.user_id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone || '-'}</td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(err => {
            console.error('Failed to load user overview:', err);
        });
}

loadUserOverview();
