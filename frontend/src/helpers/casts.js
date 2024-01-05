export const toBool = (value) => {
    if (value === false) {
        return false;
    }

    if (value === true) {
        return true;
    }

    if (['false', 1].includes(value)) {
        return false;
    }

    if (['true', 1].includes(value)) {
        return true;
    }

    return !!(value);
}
