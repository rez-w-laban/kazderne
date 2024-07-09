import { CirclePlus, Plus, Trash2, X } from "lucide-react";
import React, { useEffect, useState } from "react";
import Modal from "react-modal";
import {
  addCityMedia,
  deleteCityMedia,
  editCity,
  getCity,
} from "../../helpers/activity.helpers";
import { Avatar } from "@mui/material";
import PlaceholderImage from "../../Assets/Default/placeholder.png";
import AddPhotoAlternateIcon from "@mui/icons-material/AddPhotoAlternate";
import SuccessMessageComponent from "../SuccessComponent";
import ErrorMessageComponent from "../ErrorComponent";

const EditCityModal = ({
  isOpen,
  onRequestClose,
  city_id,
  setSuccess,
  setError,
  updateCity,
}) => {
  const [city, setCity] = useState({});
  const [cityPictures, setCityPictures] = useState([]);
  const [pic, setPic] = useState();
  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");
  const [formData, setFormData] = useState({
    city_name: "",
    description: "",
    picture: null,
  });
  const clearMessage = () => {
    setSuccessMessage("");
    setErrorMessage("");
  };

  const handleGetCity = async () => {
    try {
      const res = await getCity(city_id);
      console.log(res);
      if (res.data.status === "success") {
        setCity(res.data?.city);
        setCityPictures(res.data?.city?.city_pictures);
        setFormData({
          city_name: res.data.city?.city_name,
          description: res.data.city?.description,
          picture: res.data.city?.picture,
        });
      } else {
        setError(res.data.message);
      }
    } catch (error) {
      console.log(error);
    }
  };

  const handleProfilePictureChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setPic(file);
      setFormData({ ...formData, picture: file });
      console.log(file);
    }
  };
  const handleEditCity = async () => {
    try {
      const formDataToSend = new FormData();
      formDataToSend.append("city_name", formData.city_name);
      formDataToSend.append("description", formData.description);
      if (pic) {
        formDataToSend.append("picture", formData.picture);
      } else {
        formDataToSend.append("picture", "");
      }
      const res = await editCity(formDataToSend, { city_id: city?.id });
      console.log(res);
      if (res.data.status === "success") {
        setSuccessMessage(res.data.message);
        handleGetCity();
        setPic(null);
        updateCity();
      } else {
        setErrorMessage(res.data.message);
      }
    } catch (error) {
      console.log(error);
    }
  };

  const handleAddCityImage = async (e) => {
    const file = e.target.files[0];
    console.log(file);
    if (file) {
      const formData = new FormData();
      formData.append("media", file);
      formData.append("city_id", city?.id);
      try {
        const res = await addCityMedia(formData);
        console.log(res);
        if (res.data.status === "success") {
          setSuccessMessage(res.data.message);
          handleGetCity();
          updateCity();
        } else {
          setErrorMessage(res.data.message);
        }
      } catch (error) {
        setErrorMessage("Error uploading image");
        console.log(error);
      }
    }
  };

  const handleDeleteCityImage = async (city_media_id) => {
    try {
      const res = await deleteCityMedia({ media_id: city_media_id });
      handleGetCity();
      updateCity();
      console.log(res);
      setSuccessMessage(res.data.message);
    } catch (error) {
      console.log(error);
    }
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };

  useEffect(() => {
    handleGetCity();
  }, [city_id]);

  return (
    <Modal
      isOpen={isOpen}
      onRequestClose={onRequestClose}
      className="relative flex justify-center items-center w-full h-screen p-5 bg-black bg-opacity-30"
    >
      <div className="flex max-h-[600px] p-4 flex-col w-3/4 min-w-96 h-fit bg-slate-300 rounded-lg shadow-lg overflow-auto gap-5">
        <div className="w-full flex items-center justify-between">
          <p>Edit City</p>
          <X
            className="w-5 cursor-pointer hover:opacity-80 hover:scale-95 transition-all"
            onClick={() => onRequestClose()}
          />
        </div>
        <div className="flex gap-3 items-end">
          {pic ? (
            <Avatar
              variant="square"
              className="shadow-xl border-2 border-green-500 cursor-pointer rounded-md"
              sx={{ width: 150, height: 150 }}
              src={URL.createObjectURL(pic)}
            />
          ) : (
            <Avatar
              variant="square"
              className="shadow-xl cursor-pointer"
              sx={{ width: 150, height: 150 }}
              src={`http://127.0.0.1:8000/api/profile/${city?.id}/${city?.picture}`}
            />
          )}
          <label
            for="picture"
            className="text-sm px-2 py-1 bg-slate-500 text-white hover:opacity-80 rounded-md  h-fit font-light"
          >
            Update Profile
          </label>
          <input
            type="file"
            accept="image/*"
            hidden
            name="picture"
            id="picture"
            onChange={handleProfilePictureChange}
          />
        </div>
        <div className="flex gap-4 overflow-x-auto min-h-44 w-full p-4 rounded-md items-center justify-start">
          <label
            htmlFor="city_image"
            className="relative hover:opacity-80 cursor-pointer transition-all"
          >
            <img
              src={PlaceholderImage}
              alt=""
              className="min-w-40 max-w-40 rounded-md"
            />
            <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 ">
              <AddPhotoAlternateIcon
                fontSize="large"
                className="text-gray-700"
              />
            </div>
          </label>
          <input
            type="file"
            accept="image/*"
            hidden
            onChange={handleAddCityImage}
            name="city_image"
            id="city_image"
          />

          {cityPictures &&
            cityPictures.map((cityImage) => (
              <div className="relative">
                <img
                  src={`http://127.0.0.1:8000/api/media/${city?.id}/${cityImage?.media}`}
                  alt=""
                  className="w-48 min-w-48 rounded-md aspect-video object-cover"
                />
                <button
                  onClick={() => {
                    handleDeleteCityImage(cityImage?.id);
                  }}
                  className="bg-white absolute hover:bg-red-600 hover:text-white transition-all text-red-600 -top-3 -right-3 rounded-full px-2 py-1 shadow-lg"
                >
                  <Trash2 className="w-4" />
                </button>
              </div>
            ))}
        </div>
        <div className="flex flex-col gap-3">
          <input
            type="text"
            value={formData?.city_name}
            onChange={handleInputChange}
            name="city_name"
            id="city_name"
            placeholder="City name"
            className="px-2 py-1 rounded-md focus:bg-slate-700 placeholder:text-sm focus:text-white transition-all outline-none border-none focus:placeholder:text-gray-100"
          />
          <textarea
            type="text"
            name="description"
            value={formData.description}
            onChange={handleInputChange}
            id="description"
            placeholder="City description"
            className="px-2 py-1 rounded-md focus:bg-slate-700 placeholder:text-sm focus:text-white transition-all outline-none border-none focus:placeholder:text-gray-100"
          />
        </div>
        <div className="flex items-center justify-end gap-2 text-sm">
          <button
            onClick={() => handleEditCity()}
            className="px-2 py-1 bg-slate-600 text-white hover:opacity-80 hover:bg-green-600 transition-all cursor-pointer rounded-md"
          >
            Save Changes
          </button>
          <button
            onClick={() => {
              onRequestClose();
            }}
            className="px-2 py-1 bg-red-600 text-white hover:opacity-80 transition-all cursor-pointer rounded-md"
          >
            Dismiss
          </button>
        </div>
      </div>
      {errorMessage && (
        <ErrorMessageComponent
          message={errorMessage}
          clearMessage={clearMessage}
        />
      )}
      {successMessage && (
        <SuccessMessageComponent
          message={successMessage}
          clearMessage={clearMessage}
        />
      )}
    </Modal>
  );
};

export default EditCityModal;
