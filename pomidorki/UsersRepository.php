<?php


namespace pomidorki;


class UsersRepository
{
    use Observable;

    /**
     * @param $id
     * @return User
     */
    public function getUser($id) {
        $attributes = getUser($id);
        if (is_null($attributes)) {
            return null;
        }

        return new DatabaseUser($attributes);
    }

    public function update(User $user) {
        $user->update();
        $this->trigger("user-changed", $user);
    }
}