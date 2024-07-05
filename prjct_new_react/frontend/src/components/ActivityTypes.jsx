import { Avatar } from "@mui/material";

import React, { useEffect, useState } from "react";
import { getAllActivityTypes } from "../helpers/activity.helpers";
import { stringAvatar } from "../helpers/helpers";
import EditActivityTypeModal from "./modals/EditActivityTypeModal";
import SuccessComponent from "./SuccessComponent";
import { AddActivityTypeModal } from "./modals/AddActivityTypeModal";
import Loading from "../Assets/Lottie/loading.json";
import Lottie from "lottie-react";
import ErrorMessageComponent from "./ErrorComponent";

const ActivityTypes = () => {
  const [activityTypes, setActivityTypes] = useState();
  const [selectedActivityType, setSelectedActivityType] = useState();
  const [isOpen, setIsOpen] = useState(false);
  const [isOpenAdd, setIsOpenAdd] = useState(false);

  const [isLoading, setIsLoading] = useState(false);
  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const clearMessage = () => {
    setSuccessMessage("");
  };

  const openModal = () => {
    setIsOpen(true);
  };
  const onRequestClose = () => {
    setIsOpen(false);
  };

  const openModalAdd = () => {
    setIsOpenAdd(true);
  };
  const onRequestCloseAdd = () => {
    setIsOpenAdd(false);
  };

  const activityTypesGet = async () => {
    try {
      setIsLoading(true);
      const res = await getAllActivityTypes();
      setActivityTypes(res.data.acts);
      setIsLoading(false);
    } catch (error) {
      console.log(error);
      setIsLoading(false);
    }
  };

  useEffect(() => {
    activityTypesGet();
  }, []);
  return (
    <div className=" flex flex-col w-full   gap-8 ">
      <div className="  flex items-center justify-between px-4">
        <p className=" font-bold text-lg text-black">ActivityTypes</p>
        <p
          onClick={() => openModalAdd()}
          className="text-sm hover:border-b-2 hover:border-gray-700 border-b-2 cursor-pointer border-gray-100 transition-all"
        >
          Add New
        </p>
      </div>
      <div className="  flex rounded-lg bg-slate-600 gap-5 p-3 overflow-auto">
        {isLoading && (
          <div className="w-full flex items-center justify-center">
            <Lottie animationData={Loading} loop={true} className="w-56 " />
          </div>
        )}
        {activityTypes
          ? activityTypes.map((activityType) => (
              <div
                onClick={() => {
                  openModal();
                  setSelectedActivityType(activityType?.id);
                }}
                key={activityType?.id}
                className="flex flex-col justify-center items-center p-3 rounded-lg bg-slate-800 cursor-pointer transition-all hover:shadow-lg hover:bg-slate-200 text-white hover:text-gray-700 gap-2"
              >
                {activityType?.icon ? (
                  <Avatar
                    className="shadow-lg"
                    //add activity type icon route
                    src={`http://127.0.0.1:8000/api/icon/${activityType?.id}/${activityType?.icon}`}
                  />
                ) : (
                  <Avatar
                    className="shadow-lg"
                    {...stringAvatar(activityType?.name)}
                  />
                )}

                <p className=" text-sm font-bold ">{activityType?.name}</p>
              </div>
            ))
          : null}
      </div>
      <EditActivityTypeModal
        isOpen={isOpen}
        onRequestClose={onRequestClose}
        modalActivityType={selectedActivityType}
        updateActivityTypes={activityTypesGet}
        setSuccess={setSuccessMessage}
      />
      <AddActivityTypeModal
        isOpen={isOpenAdd}
        onRequestClose={onRequestCloseAdd}
        setSuccess={setSuccessMessage}
        setError={setErrorMessage}
        updateActivityTypes={activityTypesGet}
      />
      {successMessage && (
        <SuccessComponent
          message={successMessage}
          clearMessage={clearMessage}
        />
      )}
      {errorMessage && (
        <ErrorMessageComponent
          message={errorMessage}
          clearMessage={clearMessage}
        />
      )}
    </div>
  );
};

export default ActivityTypes;
