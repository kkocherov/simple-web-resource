let usersListContainer = document.getElementById('users-list');

let defaultPageSize = 9;

function getUsers(limit, page) {
    return $.get("/api/users", {limit, page});
}

function usersViewHTML(users) {
    let usersList = '';

    users.forEach(user => {
        usersList  += `
            <div class="card col-4" style="width: 18rem;">
                <img src="${user.image}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">${user.login}</h5>
                    <p class="card-text">user info</p>
                    <a href="/users/${user.id}" class="btn btn-success">View</a>
                </div>
            </div>`;
    });

    return usersList;
}

function renderUsers(limit, page) {
    getUsers(limit, page).then((users) => {
        let usersHTML = usersViewHTML(users);
        usersListContainer.innerHTML = usersHTML;
    });
}

$('.page-item').on('click', function(e) {
    let params = $(e.target).data();
    renderUsers(params.limit, params.page);
});

renderUsers(9, 0);
