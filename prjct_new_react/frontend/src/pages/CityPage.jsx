import React, { useEffect } from "react";
import { useState } from "react";
import {
  addActivityType,
  addCity,
  deleteCity,
  getCity,
  getCityActivities,
} from "../helpers/activity.helpers";
import { stringAvatar1 } from "../helpers/helpers";
import { Avatar } from "@mui/material";
import defaultImage from "../Assets/Default/image-ph.webp";
import ErrorMessageComponent from "../components/ErrorComponent";
import { useNavigate, useParams } from "react-router-dom";
import { Navbar } from "../components/Navbar";
import Carousel from "../components/Carousel";
import ActivitiesComponent from "../components/ActivitiesComponents";
import { FilePenLine, Trash2 } from "lucide-react";
import EditCityModal from "../components/modals/EditCityModal";
import Lottie from "lottie-react";
import LottieNoResult from "../Assets/Lottie/noResult.json";

const CityPage = () => {
  const navigate = useNavigate();

  const city_id = useParams("city_id");

  const [city, setCity] = useState();
  const [cityActivities, setCityActivities] = useState();
  const [cityPictures, setCityPictures] = useState([]);
  const [state, setState] = useState({
    cityPics: true,
    cityActs: false,
  });

  const [isOpen, setIsOpen] = useState(false);
  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const clearMessage = () => {
    setErrorMessage("");
    setSuccessMessage("");
  };

  const onRequestClose = () => {
    setIsOpen(false);
  };
  const openModal = () => {
    setIsOpen(true);
  };

  // const togglePage = (page) => {
  //   setState({ ...falseState, [page]: true });
  // };
  //   const [cityActs, cityPics] = state;

  const handleGetCity = async () => {
    try {
      const res = await getCity(city_id);
      setCity(res.data?.city);
      console.log(city);
      setCityPictures(res.data?.city?.city_pictures);
      console.log(cityPictures);
    } catch (error) {
      console.log(error);
    }
  };

  const handleGetCityActivities = async () => {
    try {
      const res = await getCityActivities(city_id);
      console.log(res);
      if (res.data.status === "success") {
        setCityActivities(res.data.activities);
      }
    } catch (error) {
      console.log(error);
    }
  };

  const handleDeleteCity = async () => {
    try {
      const res = await deleteCity(city_id);
      console.log(res);
      if (res.data.status === "success") {
        navigate(`/management`);
      }
    } catch (error) {
      console.log(error);
    }
  };

  useEffect(() => {
    handleGetCity();
    handleGetCityActivities();
  }, [city?.id]);

  return (
    <div className="w-full flex flex-col items-center justify-start">
      <Navbar />
      <div className="p-3 relative  flex flex-col w-full justify-start h-screen max-h-full  items-center gap-5 rounded-lg shadow-lg bg-slate-300 overflow-auto ">
        {cityPictures && cityPictures.length > 0 ? (
          <Carousel>
            {cityPictures.map((cityImage) => (
              <img
                key={cityImage.id}
                className="object-cover"
                src={`http://127.0.0.1:8000/api/media/${city?.id}/${cityImage?.media}`}
                alt=""
              />
            ))}
          </Carousel>
        ) : (
          <div className="w-full flex flex-col p-3 text-white items-center justify-center bg-slate-700 mt-10 rounded-lg">
            <Lottie
              animationData={LottieNoResult}
              loop={true}
              className="w-1/4 "
            />
            <p>No city images found</p>
          </div>
        )}

        <div className="flex flex-col items-center justify-start gap-5">
          <Avatar
            className="shadow-2xl"
            sx={{ width: 120, height: 120 }}
            src={`http://127.0.0.1:8000/api/profile/${city?.id}/${city?.picture}`}
          ></Avatar>
          <div className="flex flex-col  gap-2 items-center">
            <h1 className="font-bold text-xl capitalize">{city?.city_name}</h1>
            <p className=" text-sm text-gray-700">
              {city?.description ? city?.description : "description"}
            </p>
          </div>
        </div>

        <div className=""></div>
        <ActivitiesComponent className="" activities={cityActivities} />
        <div className=" flex gap-3 justify-between w-full  items-center absolute right-0 rounded-full px-5">
          <div className="flex gap-4 items-center justify-start">
            <button
              onClick={() => {
                openModal();
              }}
              className="px-2 py-1 rounded-md bg-slate-500 text-sm text-white hover:opacity-80 active:opacity-50 transition-all"
            >
              <FilePenLine className="w-8" />
            </button>
            <button
              onClick={() => handleDeleteCity()}
              className="px-2 py-1 rounded-md bg-red-600 text-sm text-white hover:opacity-80 active:opacity-50 transition-all"
            >
              <Trash2 className="w-8" />
            </button>
          </div>
        </div>
      </div>
      <EditCityModal
        onRequestClose={onRequestClose}
        isOpen={isOpen}
        updateCity={handleGetCity}
        city_id={city_id}
        setError={setErrorMessage}
        setSuccess={setSuccessMessage}
      />
    </div>
  );
};

export default CityPage;
