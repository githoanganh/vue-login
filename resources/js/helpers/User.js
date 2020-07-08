
import AppStorage from "./AppStorage";

class User {
    storeAfterLogin(res) {
        const access_token = res.data.access_token;
        AppStorage.store(access_token);
        window.axios.defaults.headers.common["Authorization"] = 'Bearer' + ' ' + access_token;
    }
    hasToken() {
        const storedToken = AppStorage.getToken();
        if (storedToken) {
            return true;
        }
        return false;
    }
    loggedIn() {
        return this.hasToken();
    }
    logout() {
        AppStorage.clear();
    }
}
export default User = new User