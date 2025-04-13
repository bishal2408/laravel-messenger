// formatting message date long
export const formatMessageDateLong = (date)=> {
    const now = new Date();
    const inputDate = new Date(date);
    
    if(isToday(inputDate)) {
        return inputDate.toLocaleTimeString([], {
            hour: "2-digit",
            minute: "2-digit",
        });
    } else if(isYesterday(inputDate)) {
        return (
            "Yesterday " + inputDate.toLocaleTimeString([], {
                hour: "2-digit",
                minute: "2-digit",
            })
        );
    } else if(inputDate.getFullYear() === now.getFullYear()) {
        return inputDate.toLocaleDateString([], {
            day: "2-digit",
            month: "short",
        });
    } else {
        return inputDate.toLocaleDateString();
    }
}

// format message date short
export const formatMessageDateShort = (date) => {
    const now = new Date();
    const inputDate = new Date(date);

    if(isToday(inputDate)) {
        return inputDate.toLocaleTimeString([], {
            hour: "2-digit",
            minute: "2-digit",
        });
    } else if(isYesterday(inputDate)) {
        return "Yesterday";
    } else if(inputDate.getFullYear() === now.getFullYear()) {
        return inputDate.toLocaleDateString([], {
            day: "2-digit",
            month: "short",
        });
    } else {
        return inputDate.toLocaleDateString();
    }
}

// check if today
export const isToday = (date) => {
    const today = new Date();

    return (
        date.getDate === today.getDate() &&
        date.getMonth === today.getMonth() &&
        date.getYear === today.getYear()
    ); 
}

// check if yesterday
export const isYesterday = (date) => {
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1)

    return (
        date.getDate === yesterday.getDate() &&
        date.getMonth === yesterday.getMonth() &&
        date.getYear === yesterday.getYear()
    ); 
}

