<template>
    <table>
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Nickname</th>
            <th>Actions</th>
        </tr>
        <tr>
            <td>{{ userInfo.full_name }}</td>
            <td>{{ userInfo.email }}</td>
            <td>{{ userInfo.nickname }}</td>
            <td>
                <button @click="logout">Logout</button>
            </td>
        </tr>
    </table>
</template>

<script>
import { async } from "q";
export default {
    data() {
        return {
            userInfo: {}
        };
    },
    methods: {
        async getUserInfo() {
            try {
                let userInfo = await axios.post("/auth/me").then();
                this.userInfo = userInfo.data;
            } catch (error) {
                console.log(error);
            }
        },
        async logout() {
            try {
                let userInfo = await axios.post("/auth/logout").then();
                User.logout();
                this.$router.push("/login");
            } catch (error) {
                console.log(error);
            }
        }
    },
    created() {
        this.getUserInfo();
    }
};
</script>

<style scoped>
table {
    border-collapse: collapse;
    width: 50%;
    margin: auto;
    margin-top: 200px;
}

th,
td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background-color: #f5f5f5;
}
</style>
