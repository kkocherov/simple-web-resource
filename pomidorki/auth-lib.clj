(defn make-world [users group]
  [users group])

(defn users [world]
  (first world))

(defn groups [world]
  (second world))

(defn make-user [login password groups]
  [login password groups])

(defn user-groups [user]
  (last user))

(defn user-login [user]
  (first user))

(defn user-password [user]
  (second user))

(defn make-group [name]
  name)

(defn group-name [group]
  group)

(defn add-user [world user]
  (make-world (conj (users world) user)
              (groups world)))

(defn remove-user [world user]
  (make-world
   (filter (fn [u] (not= (user-login u) (user-login user)))
           (users world))
   (groups world)))


(defn add-group [world group]
  (make-world
   (users world)
   (conj (groups world) group)))


(defn remove-group [world group]
  (make-world
   (users world)
   (filter (fn [g] (not= (group-name g) (group-name group)))
           (groups world))))



(defn add-user-to-group [world user group]
  (make-world (map (fn [u]
                     (if (= (user-login user) (user-login u))
                       (make-user
                        (user-login u)
                        (user-password u)
                        (conj (user-groups u) group))
                       u))
                   (users world))
              (groups world)))


(if (= 1 2)
  1
  2)

(defn addUserToGroup [])

(defn removeUserFromGroup [])



(def admin (make-user "a" "a" []))
(def admin-group (make-group "admin"))

(def world
  (-> (make-world [] [])
    (add-group admin-group)
    (add-user admin)
    (add-user-to-group admin admin-group)
    (add-user-to-group admin (make-group "guest"))
    (add-user (make-user "b" "b" []))
    (add-group (make-group "guest"))
    (add-group (make-group "test"))
    (add-user (make-user "c" "c" []))
    (remove-user (make-user "b" "b" []))
    (remove-group (make-group "test"))))

(users world)
(groups world)













(defn rights [])

(defn createRight [])

(defn deleteRight [])

(defn groups [])


(defn createGroup [])


(defn deleteGroup [])


(defn groupRights [])


(defn addRightToGroup [])


(defn removeRightFromGroup [])

(defn login [])

(defn currentUser [])

(defn logout [])

(defn isAuthorized [])
