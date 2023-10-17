import axios from "axios"
const authMiddleware = async (to, from, next) => {
    try {
        await axios.get("/api/user");
        next();
    }catch (error) {
        next('/login')
    }
}

const loginMiddleware = async (to, from, next) => {
    try {
        await axios.get("/api/user");
        next('/');
    } catch (error) {
        next();
    }
};


export { authMiddleware, loginMiddleware };
