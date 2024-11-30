import { format } from "date-fns";

export function diffForHumans(date) {
    return format(date, 'EEEE, do')
}