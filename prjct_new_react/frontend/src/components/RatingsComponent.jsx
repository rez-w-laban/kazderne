import { Avatar } from "@mui/material";
import React, { useEffect, useState } from "react";
import {
  deleteRating,
  deleterating,
  getActivityratings,
  getActivityRatings,
} from "../helpers/activity.helpers";
import { formatDateToView, stringAvatar } from "../helpers/helpers";
import Lottie from "lottie-react";
import noResult from "../Assets/Lottie/noResult.json";
import SuccessMessageComponent from "./SuccessComponent";
import ErrorMessageComponent from "./ErrorComponent";
import StarIcon from "@mui/icons-material/Star";
import { useNavigate } from "react-router-dom";
import { X } from "lucide-react";

const RatingsComponent = ({ activity_id, updateActivity }) => {
  const navigate = useNavigate();
  const [ratings, setRatings] = useState([]);
  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const clearMessage = () => {
    setErrorMessage("");
    setSuccessMessage("");
  };
  //////////
  const handleGetActivityRatings = async () => {
    try {
      const res = await getActivityRatings(activity_id);

      if (res.data.status === "success") {
        setRatings(res.data.ratings);
        console.log(res);
      }
    } catch (error) {
      console.log(error);
    }
  };

  const HandleDeleteRating = async (rating_id) => {
    try {
      const res = await deleteRating(rating_id);
      console.log(res);
      if (res.data.status === "success") {
        setSuccessMessage(res.data.message);
        handleGetActivityRatings();
        updateActivity();
      } else {
        setErrorMessage(res.data.message);
      }
    } catch (error) {
      console.log(error);
    }
  };

  useEffect(() => {
    handleGetActivityRatings();
  }, []);

  return (
    <div className="flex flex-col items-center justify-center px-3 py-2 gap-3 max-h-[600px] overflow-auto">
      {ratings.length === 0 ? (
        <div className="flex flex-col items-center justify-center w-full text-gray-50 bg-slate-400 rounded-lg px-3 py-2">
          <Lottie animationData={noResult} loop={true} />
          <p>No ratings found</p>
        </div>
      ) : (
        ratings.map((rating) => (
          <div
            key={rating?.id}
            className="flex flex-col items-start justify-center bg-white px-3 py-2 rounded-lg w-full shadow-sm text-sm gap-3"
          >
            <div className="flex items-center justify-between w-full">
              <div className="flex gap-5 w-full">
                <div className="flex items-center justify-start gap-2 w-full">
                  {rating?.user?.profile_picture ? (
                    <Avatar
                      onClick={() => navigate(`/user/${rating?.user.id}`)}
                      className="shadow-lg cursor-pointer transition-all  hover:opacity-80"
                      src={`http://127.0.0.1:8000/api/profile_picture/${rating?.user?.id}/${rating?.user?.profile_picture}`}
                    />
                  ) : (
                    <Avatar
                      onClick={() => navigate(`/user/${rating?.user.id}`)}
                      className="shadow-lg cursor-pointer transition-all  hover:opacity-80"
                      {...stringAvatar(rating?.user?.name)}
                    />
                  )}
                  <div className="flex flex-col items-start justify-start gap-1 w-full">
                    <div className="flex items-center justify-between gap-2 w-full">
                      <p
                        onClick={() => navigate(`/user/${rating?.user.id}`)}
                        className="font-bold cursor-pointer transition-all  border-transparent border-b-2 hover:border-black "
                      >
                        {rating?.user?.name}
                      </p>
                      <p className="text-xs italic text-nowrap">
                        {formatDateToView(rating?.created_at)}
                      </p>
                    </div>
                    <p className=" flex font-semibold items-center justify-start gap-2 text-white text-lg bg-yellow-600 px-2 rounded-lg text-nowrap">
                      {rating?.rating}
                      <StarIcon className="w-3" />
                    </p>
                    <div className="flex items-center justify-start gap-3 flex-wrap">
                      <p className="font-bold text-yellow-600">Feedback:</p>
                      <p className=" text-wrap">{rating?.content}</p>
                    </div>
                  </div>
                </div>
              </div>

              <div className="flex justify-end self-end items-center gap-2 flex-col">
                <button
                  onClick={() => HandleDeleteRating(rating?.id)}
                  className="px-2 py-1 bg-red-500 text-white text-xs hover:opacity-80 transition-all self-start active:opacity-50 rounded-full"
                >
                  remove
                </button>
              </div>
            </div>
          </div>
        ))
      )}
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
    </div>
  );
};

export default RatingsComponent;
