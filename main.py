import requests
from pathlib import Path

list = ['GetDiplomaAllottedStudents.php', 'getCourseDetails.php', 'getCoursesAicte.php', 'getCoursesModal.php', 'getEngineeringAllotedStudent.php', 'getEngineeringAllotedStudentOwn.php', 'getGeneralAllotedStudent.php', 'getGeneralAllotedStudentOwn.php', 'getInstitutes.php', 'getMedicalAllotedStudent.php', 'getStudentDetailsForSearchPage.php', 'getStudentNameAndGender.php', 'marqueeCode.php']
for i in list:
    file_url = "https://aicte-jk-scholarship-gov.in/jk_media/img/uploads/Announcements/do.php?url=/var/www/html/PROD_JNK/utils/partials/ajax/"+i
    # print(file_url)

    # p = Path('c:\\mr_smith\\essays\\')
    p=Path('C:\\Users\\Usman\\Documents\\autodown\\prodjnk')
    p.mkdir(exist_ok=True)

    r = requests.get(file_url, stream = True)
    with open(p / i,"wb") as file:
        for chunk in r.iter_content(chunk_size=1024):
            # writing one chunk at a time to pdf file
            if chunk:
                file.write(chunk)
