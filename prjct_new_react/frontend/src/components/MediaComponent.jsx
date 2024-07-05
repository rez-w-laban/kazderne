import React, { useEffect, useState } from "react";
import "animate.css";
import Lottie from "lottie-react";
import noResult from "../Assets/Lottie/noResult.json";

const MediaComponent = ({ activity }) => {
  const [mainImage, setMainImage] = useState("");
  const [activityPictures, setActivityPictures] = useState([]);
  const [animateImage, setAnimateImage] = useState(false);

  useEffect(() => {
    if (activity?.activity_pictures) {
      setActivityPictures(activity.activity_pictures);
      if (activity.activity_pictures.length > 0) {
        setMainImage(activity.activity_pictures[0].media);
      }
    }
  }, [activity]);

  const handleImageChange = (newImage) => {
    if (mainImage === newImage) {
      return;
    }
    setAnimateImage(true);
    setTimeout(() => {
      setMainImage(newImage);
      setAnimateImage(false);
    }, 200);
  };

  return (
    <div className="flex flex-col  items-center justify-center gap-8 mt-5">
      <div className="flex  justify-start gap-2 items-center bg-slate-400 p-7 rounded-lg overflow-auto ">
        {activityPictures[0] ? (
          activityPictures.map((activityPicture) => (
            <img
              key={activityPicture.media}
              onClick={() => handleImageChange(activityPicture.media)}
              className={
                activityPicture.media === mainImage
                  ? ` opacity-100  hover:opacity-100 shadow-lg transition-all w-20 h-20 aspect-square object-cover rounded-lg `
                  : `opacity-70 hover:opacity-100 hover:shadow-2xl shadow-lg transition-all cursor-pointer w-20 h-20 aspect-square object-cover rounded-lg `
              }
              src={`http://127.0.0.1:8000/api/media/${activity?.user_id}/${activity?.id}/${activityPicture.media}`}
              alt=""
            />
          ))
        ) : (
          <div className="flex flex-col items-center justify-center text-gray-50 bg-slate-400 rounded-lg px-3 py-2">
            <Lottie
              animationData={noResult}
              loop={true}
              className=" w-full"
            ></Lottie>
            <p>No Media found</p>
          </div>
        )}
      </div>
      {activityPictures[0] && (
        <img
          className={`w-[400px] h-[400px] aspect-square object-cover rounded-lg animate__animated ${
            animateImage ? "animate__fadeOut" : "animate__fadeIn"
          }`}
          src={`http://127.0.0.1:8000/api/media/${activity?.user_id}/${activity?.id}/${mainImage}`}
        />
      )}
    </div>
  );
};

export default MediaComponent;
