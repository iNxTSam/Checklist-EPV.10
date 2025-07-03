<?php

namespace App\Http\Controllers;

class PortalController extends Controller
{
    public function aprendiz()
    {
        $documents = [
            [
                'name' => 'Formato: Planeación, seguimiento y evaluación Etapa Productiva (F-023 Final)',
                'required' => true,
                'approved' => true,
                'rejected' => false,
                'comment' => 'Documento aprobado correctamente'
            ],
            [
                'name' => 'Comprobante de inscripción en el Indicador Agencia Pública de Empleo SENA',
                'required' => true,
                'approved' => false,
                'rejected' => true,
                'comment' => 'Falta información, reenviar documento'
            ],
            [
                'name' => 'Paz y Salvo Académico Administrativo',
                'required' => true,
                'approved' => true,
                'rejected' => false,
                'comment' => 'Validado correctamente'
            ],
            [
                'name' => 'Fotocopia documento de identidad',
                'required' => true,
                'approved' => false,
                'rejected' => false,
                'comment' => 'Pendiente por revisar'
            ],
            [
                'name' => 'Certificado de aprobación empresa (terminación etapa productiva)',
                'required' => true,
                'approved' => false,
                'rejected' => true,
                'comment' => 'Documento ilegible, favor reenviar'
            ],
            [
                'name' => 'Certificado de sustentcia prueba Saber TyT - CEET (únicamente para Tecnólogos)',
                'required' => true,
                'approved' => true,
                'rejected' => false,
                'comment' => 'Documento válido'
            ],
            [
                'name' => 'Formato entrega de documentos',
                'required' => true,
                'approved' => false,
                'rejected' => false,
                'comment' => 'Sin revisar'
            ]
        ];

        return view('aprendiz.aprendiz', compact('documents'));
    }

    public function instructor()
    {
        $students = [
            [
                'id' => 1,
                'name' => 'Valentina Vasquez Rodriguez',
                'document' => '1030556208',
                'program' => 'Tecnología en Electrónica',
                'submitted_at' => '2024-06-20',
                'total_docs' => 7,
                'approved_docs' => 3,
                'rejected_docs' => 2,
                'pending_docs' => 2,
                'status' => 'pending'
            ],
            [
                'id' => 2,
                'name' => 'Carlos Andres Martinez',
                'document' => '1020445789',
                'program' => 'Tecnología en Telecomunicaciones',
                'submitted_at' => '2024-06-18',
                'total_docs' => 7,
                'approved_docs' => 7,
                'rejected_docs' => 0,
                'pending_docs' => 0,
                'status' => 'approved'
            ],
            [
                'id' => 3,
                'name' => 'Maria Fernanda Lopez',
                'document' => '1030667890',
                'program' => 'Tecnología en Electricidad',
                'submitted_at' => '2024-06-22',
                'total_docs' => 7,
                'approved_docs' => 1,
                'rejected_docs' => 4,
                'pending_docs' => 2,
                'status' => 'revision'
            ]
        ];

        return view('instructor.instructor', compact('students'));
    }

    public function reviewStudent($id)
    {
        $student = [
            'id' => $id,
            'name' => 'Valentina Vasquez Rodriguez',
            'document' => '1030556208',
            'program' => 'Tecnología en Electrónica',
            'submitted_at' => '2024-06-20'
        ];

        $documents = [
            [
                'id' => 1,
                'name' => 'Formato: Planeación, seguimiento y evaluación Etapa Productiva (F-023 Final)',
                'required' => true,
                'approved' => true,
                'rejected' => false,
                'comment' => 'Documento aprobado correctamente',
                'file_path' => '/documents/formato_planeacion.pdf',
                'uploaded_at' => '2024-06-20 09:15:00'
            ],
            [
                'id' => 2,
                'name' => 'Comprobante de inscripción en el Indicador Agencia Pública de Empleo SENA',
                'required' => true,
                'approved' => false,
                'rejected' => true,
                'comment' => 'Falta información, reenviar documento',
                'file_path' => '/documents/comprobante_inscripcion.pdf',
                'uploaded_at' => '2024-06-20 10:30:00'
            ],
            [
                'id' => 3,
                'name' => 'Paz y Salvo Académico Administrativo',
                'required' => true,
                'approved' => true,
                'rejected' => false,
                'comment' => 'Validado correctamente',
                'file_path' => '/documents/paz_salvo.pdf',
                'uploaded_at' => '2024-06-20 11:45:00'
            ],
            [
                'id' => 4,
                'name' => 'Fotocopia documento de identidad',
                'required' => true,
                'approved' => false,
                'rejected' => false,
                'comment' => '',
                'file_path' => '/documents/cedula.pdf',
                'uploaded_at' => '2024-06-20 14:20:00'
            ],
            [
                'id' => 5,
                'name' => 'Certificado de aprobación empresa (terminación etapa productiva)',
                'required' => true,
                'approved' => false,
                'rejected' => false,
                'comment' => '',
                'file_path' => null,
                'uploaded_at' => null
            ],
            [
                'id' => 6,
                'name' => 'Certificado de sustentcia prueba Saber TyT - CEET (únicamente para Tecnólogos)',
                'required' => true,
                'approved' => false,
                'rejected' => false,
                'comment' => '',
                'file_path' => '/documents/saber_tyt.pdf',
                'uploaded_at' => '2024-06-21 08:30:00'
            ],
            [
                'id' => 7,
                'name' => 'Formato entrega de documentos',
                'required' => true,
                'approved' => false,
                'rejected' => false,
                'comment' => '',
                'file_path' => null,
                'uploaded_at' => null
            ]
        ];

        return view('instructor.review', compact('student', 'documents'));
    }

    public function updateDocument()
    {
        return response()->json(['success' => true, 'message' => 'Documento actualizado correctamente']);
    }
}