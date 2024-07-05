function stringAvatar(name) {
  if (!name) {
    return {
      sx: {
        bgcolor: stringToColor("unknown"),
      },
      children: "U",
    };
  }

  const nameParts = name.split(" ");
  const initials = nameParts.length > 1
    ? `${nameParts[0][0]}${nameParts[1][0]}`
    : nameParts[0][0];

  return {
    sx: {
      bgcolor: stringToColor(name),
    },
    children: initials,
  };
}

function stringAvatar1(name) {
  if (!name) {
    return {
      
      sx: {
        bgcolor: stringToColor("unknown"),
      },
      children: "U",
    };
  }

  const nameParts = name.split(" ");
  const initials = nameParts.length > 1
    ? `${nameParts[0][0]}${nameParts[1][0]}`
    : nameParts[0][0];

  return {
   
    sx: {
       width: 120, height: 120 ,
       bgcolor: stringToColor(name),
    },
    children: initials,
  };
}




  function stringToColor(string) {
    let hash = 0;
    let i;
  
    for (i = 0; i < string.length; i += 1) {
      hash = string.charCodeAt(i) + ((hash << 5) - hash);
    }
  
    let color = "#";
  
    for (i = 0; i < 3; i += 1) {
      const value = (hash >> (i * 8)) & 0xff;
      color += `00${value.toString(16)}`.slice(-2);
    }
  
    return color;
  }

  

  
function formatDateToView(dateString) {
  const date = new Date(dateString);

  const options = {
    year: "numeric",
    month: "short",
    day: "numeric",
  };

  return date.toLocaleDateString(undefined, options);
}

  export {stringAvatar1,stringAvatar ,formatDateToView }