import { CalendarDate} from '@internationalized/date'

export function calendarDateFormatter(date) {
    let dateString = new Date(date);

    let year = dateString.getFullYear()
    let month = dateString.getMonth() + 1
    let day = dateString.getDate()
    
    return new CalendarDate(year, month, day);
}