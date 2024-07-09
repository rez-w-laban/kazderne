import axios from "axios";
import { auth } from "./auth.helpers";
const baseUrl = "http://127.0.0.1:8000/api/";

async function adminUserSearch(query) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/adminUserSearch`,
      { search: query },
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function getMyProfile() {
  try {
    const res = await axios.get(`${baseUrl}user/profile`, auth());
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function getUser(user_id) {
  //with activities

  try {
    const res = await axios.get(`${baseUrl}user/getUser/${user_id}`, auth());
    const data = res.data;
    console.log(data);
    return { data };
  } catch (error) {
    console.log(error);
    throw error;
  }
}

async function getAllUsers() {
  try {
    const res = await axios.get(`${baseUrl}getAllUsers`);
    const data = res.data;
    return { data };
  } catch (error) {
    console.log(error);
    throw error;
  }
}

async function deleteUser({ user_id }) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/deleteUser/${user_id}`,
      undefined,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function userPrivilege(user_id) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/sadmin/userPrivilege/${user_id}`,
      undefined,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

export {
  getUser,
  getAllUsers,
  deleteUser,
  userPrivilege,
  getMyProfile,
  adminUserSearch,
};
