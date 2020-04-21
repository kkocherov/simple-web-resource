let usersListContainer = document.getElementById('users-list');

$.get("/api/users", {}, function(users) {
    let usersList = '';

    users.forEach(user => {
        usersList  += `
            <div class="card" style="width: 18rem;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">${user.login}</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/users/${user.uuid}" class="btn btn-success">View</a>
                </div>
            </div>`;
    });

    usersListContainer.innerHTML = usersList;
});