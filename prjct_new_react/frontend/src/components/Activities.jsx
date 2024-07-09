import React from "react";
import { getAllUsers } from "../helpers/user.helpers";
import Lottie from "lottie-react";
import LoadingAnimation from "../Assets/Lottie/loading.json";

import { useState, useEffect } from "react";
import { formatDateToView } from "../helpers/helpers";
import PinDropIcon from "@mui/icons-material/PinDrop";
import {
  adminActivitySearch,
  getAllActivities,
} from "../helpers/activity.helpers";
import ModeCommentIcon from "@mui/icons-material/ModeComment";
import FavoriteIcon from "@mui/icons-material/Favorite";
import BookmarkAddedIcon from "@mui/icons-material/BookmarkAdded";
import StarIcon from "@mui/icons-material/Star";
import SuccessMessageComponent from "./SuccessComponent";
import { useNavigate } from "react-router-dom";

export const Activities = () => {
  const [selectedActivity, setSelectedActivity] = useState();
  const [activityFormData, setActivityFormData] = useState("");
  const [activities, setActivities] = useState([]);
  const [isOpen, setIsOpen] = useState(false);
  const [users, setUsers] = useState([]);
  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");
  const [isLoading, setIsLoading] = useState(false);

  const openModal = () => {
    setIsOpen(true);
  };
  const navigate = useNavigate();

  const onRequestClose = () => {
    setIsOpen(false);
  };

  const handleInputChange = (e) => {
    setActivityFormData(e.target.value);
    search(activityFormData);
  };

  const clearMessage = () => {
    setErrorMessage("");
    setSuccessMessage("");
  };

  const search = async (query) => {
    try {
      setIsLoading(true);
      const res = await adminActivitySearch(query);
      setIsLoading(false);
      console.log(res);
      if (res.data.status === "success") {
        setActivities(res.data.activities);
      }
    } catch (error) {
      console.log(error);
      setErrorMessage(error);
    }
  };

  useEffect(() => {
    search(activityFormData);
  }, [activityFormData]);

  return (
    <div className="flex-col w-full pb-10 ">
      <div className="flex p-5   cursor-default items-center text-black justify-between ">
        <div className="flex items-center justify-start w-full ">
          <h4 className="font-bold  uppercase">Activities</h4>
        </div>
        <div className=" w-full flex justify-center items-center">
          <input
            type="text"
            name="activities"
            placeholder="Search Activities..."
            value={activityFormData}
            onChange={handleInputChange}
            autoComplete="off"
            className="m-3 placeholder:text-[#4F5D75] bg-transparent px-3 py-1 text-base w-full border-b-2 border-b-gray-800 outline-none transition-all focus:border-b-[#4F5D75]"
          />
        </div>
        <div className="flex items-center justify-end w-full "></div>
      </div>

      <div className="flex items-stretch  justify-center flex-wrap w-full gap-8  bg-gray-600 p-5 rounded-lg cursor-default shadow-lg text-black">
        {isLoading ? (
          <Lottie
            animationData={LoadingAnimation}
            loop={true}
            className=" w-52 drop-shadow-lg"
          />
        ) : activityFormData !== "" && activities?.length === 0 ? (
          <div>no results </div>
        ) : (
          activities?.map((activity) => (
            <div
              onClick={() => {
                navigate(`/activity/${activity?.id}`);
              }}
              key={activity?.id}
              className="relative gap-2 hover:shadow-2xl hover:opacity-85 text-gray-700 flex flex-col h-96 bg-white hover:bg-yellow-600 hover:text-white rounded-md w-72 overflow-hidden shadow-lg hover:scale-95 transition-all cursor-pointer"
            >
              <img
                className="w-72 object-cover aspect-square shadow-lg"
                src={`http://127.0.0.1:8000/api/profile/${activity?.user_id}/${activity?.id}/${activity?.picture}`}
                alt=""
              ></img>
              <div className="flex items-center justify-between">
                <div className="flex items-end justify-start w-full px-2 gap-2">
                  <p className="text-lg font-bold">{activity?.activity_name}</p>
                </div>
                <PinDropIcon></PinDropIcon>
                <p className="px-2 text-xs italic">
                  {activity?.city.city_name}
                </p>
              </div>
              <div className="absolute flex justify-center items-center right-3 top-3 px-3 py-1  bg-white rounded-full text-yellow-400">
                <StarIcon></StarIcon>
                <p className="ml-1">{activity?.average_rate}</p>
              </div>

              <div className="flex items-center justify-evenly p-2 rounded-full bg-white mx-3">
                <div className="flex items-center justify-center">
                  <FavoriteIcon className="text-red-600 shadow-sm"></FavoriteIcon>
                  <p className="text-sm text-red-600 shadow-sm">
                    {activity?.likes_count}
                  </p>
                </div>
                <div className="flex items-center justify-center">
                  <ModeCommentIcon className="text-gray-500 shadow-sm"></ModeCommentIcon>
                  <p className="text-sm text-gray-500 shadow-sm">
                    {activity?.comments_count}
                  </p>
                </div>
                <div className="flex items-center justify-center">
                  <BookmarkAddedIcon className="text-green-600 shadow-sm"></BookmarkAddedIcon>
                  <p className="text-sm text-red-green shadow-sm">
                    {activity?.bookmarks_count}
                  </p>
                </div>
              </div>
            </div>
          ))
        )}
      </div>

      <div className="flex absolute top-20 right-10 text-nowrap">
        {successMessage && (
          <SuccessMessageComponent
            message={successMessage}
            clearMessage={clearMessage}
          />
        )}
      </div>
    </div>
  );
};
