import { useToast } from "@/Components/ui/toast"
import { router, usePage } from "@inertiajs/vue3"

const {toast} = useToast();

export const notifications = () => {
    
    router.on('finish', ()=>{
        const notifications = usePage().props.notifications 
     
        toast({
            variant: notifications.type,
            title: notifications.type.charAt(0).toUpperCase() + notifications.type.slice(1),
            description: notifications.body
        })
    })

}