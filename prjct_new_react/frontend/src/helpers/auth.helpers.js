import axios from "axios";

const baseUrl = "http://127.0.0.1:8000/api/";

const auth = () => {
  const token = localStorage.getItem("token");

  return {
    headers: token ? { Authorization: `Bearer ${token}` } : {},
  };
};

async function login({ email, password }) {
  try {
    const res = await axios.post(`${baseUrl}login`, { email, password });
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function logout() {
  try {
    const res = await axios.post(`${baseUrl}user/logout`, undefined, auth());
    if (res.status === 200) {
      const data = res.data;
      return { data };
    }
  } catch (error) {
    throw error;
  }
}

export { login, auth, logout };
