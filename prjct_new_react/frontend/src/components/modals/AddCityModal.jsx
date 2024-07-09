import React from "react";
import { useState } from "react";
import Modal from "react-modal";
import { addActivityType, addCity } from "../../helpers/activity.helpers";
import { stringAvatar1 } from "../../helpers/helpers";
import { Avatar } from "@mui/material";
import defaultImage from "../../Assets/Default/image-ph.webp";
import ErrorMessageComponent from "../ErrorComponent";
import { X } from "lucide-react";

export const AddCityModal = ({
  isOpen,
  onRequestClose,
  setSuccess,
  setError,
  updateCities,
}) => {
  const [pic, setPic] = useState();
  const [errorMessage, setErrorMessage] = useState("");

  function clearMessage() {
    setErrorMessage("");
  }

  const [formData, setFormData] = useState({
    city_name: "",
    description: "",
    location: "",
    picture: null,
  });

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };

  const handleProfilePictureChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setPic(file);
      setFormData({ ...formData, picture: file });
      console.log(file);
    }
  };
  const handleAddCity = async () => {
    try {
      const formDataToSend = new FormData();
      formDataToSend.append("city_name", formData.city_name);
      formDataToSend.append("description", formData.description);
      formDataToSend.append("location", formData.location);
      if (formData.picture instanceof File) {
        formDataToSend.append("picture", formData.picture);
      }

      const res = await addCity(formDataToSend);
      console.log(res);
      if (res.data.status === "success") {
        onRequestClose();
        setFormData({
          city_name: "",
          picture: null,
          description: "",
          location: "",
        });
        setPic(null);
        setSuccess(res.data.message);
        updateCities();
      } else {
        setErrorMessage(res.data.message);
        console.log(res);
      }
    } catch (error) {
      console.log(error);
    }
  };
  return (
    <Modal
      className="relative flex justify-center items-center w-full h-screen p-5 bg-black bg-opacity-30"
      isOpen={isOpen}
      onRequestClose={onRequestClose}
    >
      <div className="flex max-h-[600px] p-4 flex-col w-1/2 h-fit bg-slate-300 rounded-lg shadow-lg overflow-auto">
        <div className="flex w-full justify-between p-3 ">
          <p className=" font-bold">Add New City</p>
          <button
            className="flex justify-center  text-lg text-white px-2  hover:opacity-70 transition-all bg-red-500 rounded-full"
            onClick={() => {
              onRequestClose();
              setFormData({
                city_name: "",
                picture: null,
                description: "",
                location: "",
              });
              setPic(null);
            }}
          >
            <X className="w-4" />
          </button>
        </div>
        <div className="flex justify-start items-start gap-5 flex-wrap">
          <input
            hidden
            type="file"
            id="icon"
            name="icon"
            accept="image/*"
            onChange={handleProfilePictureChange}
          />
          <label htmlFor="icon">
            <div className="flex w-full items-center justify-center  rounded-md">
              {pic ? (
                <Avatar
                  variant="square"
                  className="shadow-xl border-2 border-slate-300 cursor-pointer rounded-md"
                  sx={{ width: 120, height: 120 }}
                  src={URL.createObjectURL(pic)}
                />
              ) : (
                <Avatar
                  variant="square"
                  className="shadow-xl border-2 border-slate-300 cursor-pointer"
                  sx={{ width: 120, height: 120 }}
                  src={defaultImage}
                />
              )}
            </div>
          </label>
          <div className="flex flex-col items-start w-full justify-center gap-5">
            <input
              type="text"
              value={formData.city_name}
              onChange={handleInputChange}
              name="city_name"
              id="city_name"
              placeholder="City Name"
              className=" placeholder:text-sm outline-none border-b-2 border-white px-2 py-1 rounded-md w-full focus:border-b-2 focus:border-slate-500 transition-all"
            />

            <textarea
              type="text"
              value={formData.description}
              onChange={handleInputChange}
              name="description"
              id="description"
              placeholder="Description"
              className=" placeholder:text-sm outline-none border-b-2 border-white px-2 py-1 rounded-md w-full focus:border-b-2 focus:border-slate-500 transition-all"
            />
            <div className=" flex items-center justify-end w-full">
              <button
                onClick={() => handleAddCity()}
                className=" text-sm rounded-full text-white px-2 py-1 bg-green-600 hover:opacity-70 shadow-md"
              >
                Create
              </button>
            </div>
          </div>
        </div>
      </div>
      {errorMessage && (
        <ErrorMessageComponent
          message={errorMessage}
          clearMessage={clearMessage}
        />
      )}
    </Modal>
  );
};
