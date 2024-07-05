import axios from "axios";
import { auth } from "./auth.helpers";

const baseUrl = "http://127.0.0.1:8000/api/";

//cities

async function getAllCities() {
  try {
    const res = await axios.get(`${baseUrl}getAllCities`, auth());
    const data = res.data;
    return { data };
  } catch (error) {
    console.log(error);
  }
}

async function getCity({ city_id }) {
  try {
    const res = await axios.get(`${baseUrl}getCity/${city_id}`);
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function getCityActivities({ city_id }) {
  try {
    const res = await axios.get(`${baseUrl}getCityActivities/${city_id}`);
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function addCityMedia(media) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/addCityMedia`,
      media,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function deleteCityMedia({ media_id }) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/deleteCityMedia/${media_id}`,
      undefined,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    console.log(error);
    throw error;
  }
}

async function addCity(formData) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/addCity`,
      formData,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function editCity(formData, { city_id }) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/editCity/${city_id}`,
      formData,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function deleteCity({ city_id }) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/deleteCity/${city_id}`,
      undefined,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function addActivityType(formData) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/addActivityType`,
      formData,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function editActivityType(formData, activity_type_id) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/editActivityType/${activity_type_id}`,
      formData,
      auth()
    );
    const data = res.data;
    console.log(data);
    return { data };
  } catch (error) {
    throw error;
  }
}

async function deleteActivityType(activity_type_id) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/deleteActivityType/${activity_type_id}`,
      undefined,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    console.log(error);
    throw error;
  }
}

async function getAllActivityTypes() {
  try {
    const res = await axios.get(`${baseUrl}getAllActivityTypes`, undefined);
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function getActivityType(activity_type_id) {
  try {
    const res = await axios.get(
      `${baseUrl}getActivityType/${activity_type_id}`
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

//activities

async function searchActivities(query) {
  try {
    const res = await axios.get(
      `${baseUrl}user/searchActivities`,
      { search: query },
      auth()
    );
    if (res.status === 200) {
      const data = res.data;
      return { data };
    }
  } catch (error) {
    throw error;
  }
}

async function getAllActivities() {
  try {
    const res = await axios.get(`${baseUrl}getAllActivities`);
    const data = res.data;

    return { data };
  } catch (error) {
    console.log(error);
    throw error;
  }
}

async function getActivity({ activity_id }) {
  try {
    const res = await axios.get(`${baseUrl}getActivity/${activity_id}`);
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function getActivityComments({ activity_id }) {
  try {
    const res = await axios.get(`${baseUrl}getActivityComments/${activity_id}`);
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function getActivityRatings(activity_id) {
  try {
    const res = await axios.get(`${baseUrl}getActivityRatings/${activity_id}`);
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function deleteRating(rating_id) {
  try {
    const res = await axios.post(
      `${baseUrl}user/deleteRating/${rating_id}`,
      undefined,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function deleteComment(comment_id) {
  try {
    const res = await axios.post(
      `${baseUrl}user/deleteComment/${comment_id}`,
      undefined,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function getActivityLikes(activity_id) {
  try {
    const res = await axios.get(
      `${baseUrl}user/admin/getActivityLikes/${activity_id}`,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function deleteActivity({ activity_id }) {
  try {
    const res = await axios.post(
      `${baseUrl}user/deleteActivity/${activity_id}`,
      undefined,
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function adminActivitySearch(query) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/adminActivitySearch`,
      { search: query },
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

async function adminCitySearch(query) {
  try {
    const res = await axios.post(
      `${baseUrl}user/admin/adminCitySearch`,
      { search: query },
      auth()
    );
    const data = res.data;
    return { data };
  } catch (error) {
    throw error;
  }
}

export {
  getAllCities,
  getCity,
  getCityActivities,
  addCityMedia,
  deleteCityMedia,
  addCity,
  editCity,
  deleteCity,
  addActivityType,
  editActivityType,
  deleteActivityType,
  getAllActivityTypes,
  getActivityType,
  searchActivities,
  getActivityLikes,
  getAllActivities,
  getActivity,
  getActivityComments,
  getActivityRatings,
  deleteRating,
  deleteComment,
  deleteActivity,
  adminActivitySearch,
  adminCitySearch,
};
