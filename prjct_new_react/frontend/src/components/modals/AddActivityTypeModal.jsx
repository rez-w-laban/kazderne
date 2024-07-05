import React from "react";
import { useState } from "react";
import Modal from "react-modal";
import { addActivityType } from "../../helpers/activity.helpers";
import { stringAvatar1 } from "../../helpers/helpers";
import { Avatar } from "@mui/material";
import defaultImage from "../../Assets/Default/image-ph.webp";
import ErrorMessageComponent from "../ErrorComponent";
import { X } from "lucide-react";

export const AddActivityTypeModal = ({
  isOpen,
  onRequestClose,
  setSuccess,
  setError,
  updateActivityTypes,
}) => {
  const [pic, setPic] = useState();
  const [errorMessage, setErrorMessage] = useState("");

  function clearMessage() {
    setErrorMessage("");
  }

  const [formData, setFormData] = useState({
    name: "",
    icon: null,
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
      setFormData({ ...formData, icon: file });
      console.log(file);
    }
  };
  const handleAddActivityType = async () => {
    try {
      const formDataToSend = new FormData();
      formDataToSend.append("name", formData.name);
      if (formData.icon instanceof File) {
        formDataToSend.append("icon", formData.icon);
      }

      const res = await addActivityType(formDataToSend);
      console.log(res);
      if (res.data.status === "success") {
        onRequestClose();
        setFormData({ name: "", icon: null });
        setSuccess(res.data.message);
        updateActivityTypes();
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
      <div className="flex p-4 flex-col w-1/2 h-fit bg-slate-300 rounded-lg shadow-lg ">
        <div className="flex w-full justify-between p-3 ">
          <p className=" font-bold">Add</p>
          <button
            className="flex justify-center  text-lg text-white px-2  hover:opacity-70 transition-all bg-red-500 rounded-full"
            onClick={() => {
              onRequestClose();
              setFormData({ name: "", icon: null });
              setPic(null);
            }}
          >
            <X className="w-4" />
          </button>
        </div>
        <div className="flex justify-start items-center gap-5">
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
              value={formData.name}
              onChange={handleInputChange}
              name="name"
              id="name"
              placeholder="Activity type name"
              className=" placeholder:text-sm outline-none border-b-2 border-white px-2 py-1 rounded-sm w-full focus:border-b-2 focus:border-slate-500 transition-all"
            />
            <div className=" flex items-center justify-between w-full">
              <button
                onClick={() => handleAddActivityType()}
                className=" text-sm rounded-full text-white px-2 py-1 bg-green-600 hover:opacity-70 shadow-md"
              >
                Create
              </button>
              <button className="text-sm rounded-full text-white px-2 py-1 active:opacity-50 transition-all bg-red-600 hover:opacity-70 shadow-md">
                Dismiss
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
