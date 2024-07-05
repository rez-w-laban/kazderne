import Modal from "react-modal";
import React, { act, useEffect, useState } from "react";
import { Avatar, stepClasses } from "@mui/material";
import { stringAvatar, stringAvatar1 } from "../../helpers/helpers";
import {
  deleteActivityType,
  editActivityType,
  getActivityType,
} from "../../helpers/activity.helpers";

const EditActivityTypeModal = ({
  isOpen,
  onRequestClose,
  modalActivityType,
  updateActivityTypes,
  setSuccess,
}) => {
  const [pic, setPic] = useState();
  const [activityType, setActivityType] = useState();
  const [formData, setFormData] = useState({
    name: "",
    icon: null,
  });

  const [latestFormData, setLatestFormData] = useState({
    name: "",
    icon: null,
  });
  const activityTypeGet = async (id) => {
    try {
      const res = await getActivityType(id);
      setActivityType(res.data.activity);
      setFormData({
        name: res.data.activity?.name,
        icon: res.data.activity?.icon,
      });
      setLatestFormData({
        name: res.data.activity?.name,
        icon: res.data.activity?.icon,
      });
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

  const handleProfilePictureChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setPic(file);
      setFormData({ ...formData, icon: file });
      console.log(file);
    }
  };
  const handleEditActivityType = async () => {
    try {
      const formDataToSend = new FormData();
      formDataToSend.append("name", formData.name);
      if (formData.icon instanceof File) {
        formDataToSend.append("icon", formData.icon);
      }

      const res = await editActivityType(formDataToSend, modalActivityType);
      console.log(res);
      if (res.data.status === "Success") {
        activityTypeGet(modalActivityType);
        updateActivityTypes();
        onRequestClose();
        setSuccess(res.data.message);
      }
    } catch (error) {
      console.log(error);
    }
  };

  const handleDeleteActivityType = async () => {
    try {
      const res = await deleteActivityType(modalActivityType);
      console.log(res);
      if (res.data.status === "success") {
        updateActivityTypes();
        onRequestClose();
        setSuccess(res.data.message);
      }
    } catch (error) {
      console.log(error);
    }
  };

  useEffect(() => {
    if (modalActivityType) {
      activityTypeGet(modalActivityType);
    }
  }, [modalActivityType]);
  return (
    <Modal
      className=" flex justify-center items-center w-full h-screen p-5 bg-black bg-opacity-30"
      isOpen={isOpen}
      onRequestClose={onRequestClose}
    >
      <div className="flex p-4 flex-col w-1/2 h-fit bg-slate-300 rounded-lg shadow-lg ">
        <div className="flex w-full justify-between p-3 ">
          <p className=" font-bold">Edit</p>
          <button
            className="flex justify-center  text-lg text-white px-2  hover:opacity-70 transition-all bg-red-500 rounded-full"
            onClick={() => {
              onRequestClose();
              setPic(null);
              setFormData(latestFormData);
            }}
          >
            X
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
            <div className="flex w-full items-center justify-center">
              {pic ? (
                <Avatar
                  className="shadow-xl border-2 border-slate-300 cursor-pointer"
                  sx={{ width: 120, height: 120 }}
                  src={URL.createObjectURL(pic)}
                />
              ) : activityType?.icon ? (
                <Avatar
                  className="shadow-xl border-2 border-slate-300 cursor-pointer"
                  sx={{ width: 120, height: 120 }}
                  src={`http://127.0.0.1:8000/api/icon/${modalActivityType}/${activityType?.icon}`}
                />
              ) : (
                <Avatar
                  className="shadow-xl border-2 border-slate-300 cursor-pointer"
                  {...stringAvatar1(activityType?.name)}
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
                onClick={() => handleEditActivityType()}
                className=" text-sm rounded-full text-white px-2 py-1 bg-green-600 hover:opacity-70 shadow-md"
              >
                Save Changes
              </button>
              <button
                onClick={handleDeleteActivityType}
                className="text-sm rounded-full text-white px-2 py-1 active:opacity-50 transition-all bg-red-600 hover:opacity-70 shadow-md"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </Modal>
  );
};

export default EditActivityTypeModal;
