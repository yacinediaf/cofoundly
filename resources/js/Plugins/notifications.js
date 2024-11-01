import { useToast } from "@/Components/ui/toast"
import { router, usePage } from "@inertiajs/vue3"

const {toast} = useToast();

export const notifications = () => {
    router.on('finish', ()=>{
        const notification = usePage().props.notifications 
        
        if (notification.length != 0) {
            toast({
                variant: notification.type,
                title: notification.type?.charAt(0).toUpperCase() + notification.type?.slice(1),
                description: notification.body
            })
        }
    })

}