import { usePage } from '@inertiajs/vue3'
import { UserTypeEnum } from '@/utils/userTypeEnum';

export const isSystemUser = () => {
    const { auth } = usePage().props;
    const userType = auth.user_type || '';
    return userType === UserTypeEnum.SYSTEM;
};